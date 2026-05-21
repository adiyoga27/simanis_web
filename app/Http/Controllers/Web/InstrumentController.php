<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\InstrumentGroup;
use App\Models\InstrumentResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InstrumentController extends Controller
{
    public function index()
    {
        $groups = InstrumentGroup::with('questions')->orderBy('order')->get();

        if ($groups->isEmpty()) {
            return back()->with('error', 'Belum ada pertanyaan instrument.');
        }

        return view('instruments.form', compact('groups'));
    }

    public function store(Request $request)
    {
        $groups = InstrumentGroup::with('questions')->orderBy('order')->get();

        $rules = [];
        foreach ($groups as $group) {
            foreach ($group->questions as $q) {
                $rules["answers.{$q->id}"] = 'required|in:1,2,3';
            }
        }

        $validated = $request->validate($rules, [
            'answers.*.required' => 'Semua pertanyaan harus dijawab.',
        ]);

        $answers = $validated['answers'];
        $totalScore = array_sum($answers);
        $maxScore = $groups->sum(fn($g) => $g->questions->count()) * 3;
        $percentage = round(($totalScore / $maxScore) * 100, 2);

        $interpretation = match (true) {
            $percentage >= 76 => 'Keyakinan Tinggi',
            $percentage >= 60 => 'Keyakinan Sedang',
            default           => 'Keyakinan Rendah',
        };

        $answersDetail = [];
        foreach ($groups as $group) {
            foreach ($group->questions as $q) {
                $val = (int) ($answers[$q->id] ?? 0);
                $answersDetail[] = [
                    'group_title' => $group->title,
                    'question'    => $q->question,
                    'answer'      => $val,
                    'label'       => match ($val) {
                        1 => 'Tidak Setuju', 2 => 'Kurang Setuju', 3 => 'Setuju', default => '-'
                    },
                ];
            }
        }

        $result = InstrumentResult::create([
            'user_id'        => Auth::id(),
            'total_score'    => $totalScore,
            'max_score'      => $maxScore,
            'percentage'     => $percentage,
            'interpretation' => $interpretation,
            'answers'        => $answersDetail,
        ]);

        return redirect()->route('instruments.result', $result->id);
    }

    public function result($id)
    {
        $result = InstrumentResult::where('user_id', Auth::id())->findOrFail($id);

        return view('instruments.result', compact('result'));
    }

    public function history()
    {
        $results = InstrumentResult::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('instruments.history', compact('results'));
    }
}
