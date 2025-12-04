<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guest;
use App\Models\History;
use Illuminate\Support\Str; // ហៅប្រើ Str helper

class WeddingController extends Controller
{
    public function index(Request $request)
    {
        $totalMoney = Guest::sum('amount');
        $totalPeople = Guest::sum('guests_count');
        $totalEnvelopes = Guest::count();
        
        $query = Guest::query();
        if ($request->sort == 'highest') $query->orderBy('amount', 'desc');
        elseif ($request->sort == 'lowest') $query->orderBy('amount', 'asc');
        else $query->latest();
        
        $guests = $query->limit(50)->get();

        // 🔥 ថ្មី៖ ទាញយក History មកជាមួយគ្នា (៥០ សកម្មភាពចុងក្រោយ)
        $histories = History::latest()->limit(50)->get();

        return view('welcome', compact('guests', 'histories', 'totalMoney', 'totalPeople', 'totalEnvelopes'));
    }

    // ... function store នៅដដែល ...
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'amount' => 'required|numeric',
            'guests_count' => 'required|integer',
            'photo' => 'nullable|image|max:10240',
        ]);

        $path = null;
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('receipts', 'public');
        }

        Guest::create([
            'name' => $request->name,
            'amount' => $request->amount,
            'guests_count' => $request->guests_count,
            'image_path' => $path,
            'description' => $request->description,
        ]);

        History::create([
            'action' => 'CREATE',
            'target_name' => $request->name,
            'details' => "បានកត់ត្រាថ្មី: $" . $request->amount,
        ]);

        return back()->with('success', '✅ កត់ត្រាជោគជ័យ!');
    }

   public function update(Request $request, $id)
    {
        $guest = Guest::findOrFail($id);
        
        // 1. ទុកទិន្នន័យចាស់សិន (មុនពេលកែ)
        $oldName = $guest->name;
        $oldAmount = $guest->amount;
        $oldCount = $guest->guests_count;

        // 2. រៀបចំឈ្មោះថ្មី (ដាក់ Edited)
        $newName = $request->name;
        if (!Str::endsWith($newName, ' (Edited)')) {
            $newName = $newName . ' (Edited)';
        }

        // 3. ធ្វើការកែប្រែទិន្នន័យចូល Database
        $guest->update([
            'name' => $newName,
            'amount' => $request->amount,
            'guests_count' => $request->guests_count,
            'description' => $request->description,
            'edited_at' => now(),
        ]);

        // 4. 🔥 ស្វែងរកចំណុចផ្លាស់ប្តូរ ដើម្បីសរសេរចូល History
        $changes = [];

        // ក. បើកែឈ្មោះ
        // (យើងដកពាក្យ Edited ចេញសិនពេលផ្ទៀងផ្ទាត់ ដើម្បីកុំឱ្យច្រឡំ)
        $cleanOldName = str_replace(' (Edited)', '', $oldName);
        $cleanNewName = str_replace(' (Edited)', '', $newName);
        
        if ($cleanOldName !== $request->name) { // ប្រៀបធៀបឈ្មោះដើម
             $changes[] = "កែឈ្មោះពី [$oldName] ទៅ [$newName]";
        }

        // ខ. បើកែទឹកប្រាក់
        if ($oldAmount != $request->amount) {
             $changes[] = "កែប្រាក់ពី [$" . number_format($oldAmount, 2) . "] ទៅ [$" . number_format($request->amount, 2) . "]";
        }

        // គ. បើកែចំនួនមនុស្ស
        if ($oldCount != $request->guests_count) {
             $changes[] = "កែចំនួនពី [$oldCount នាក់] ទៅ [$request->guests_count នាក់]";
        }

        // ឃ. បើគ្មានអ្វីប្តូរទេ (តែគាត់ចុច Save)
        if (empty($changes)) {
            $logDetails = "បានចុចកែប្រែ (តែគ្មានទិន្នន័យផ្លាស់ប្តូរ)";
        } else {
            // យកសារទាំងអស់មកបូកបញ្ចូលគ្នា (ឃ្លាតគ្នាដោយ ក្បៀស)
            $logDetails = implode(", ", $changes);
        }

        // 5. កត់ចូល History
        History::create([
            'action' => 'UPDATE',
            'target_name' => $newName,
            'details' => $logDetails, // 📝 ដាក់សារលម្អិតដែលយើងបង្កើតខាងលើ
        ]);

        return back()->with('success', '✏️ កែប្រែទិន្នន័យជោគជ័យ!');
    }

    // ... function destroy នៅដដែល ...
    public function destroy($id)
    {
        $guest = Guest::findOrFail($id);
        $name = $guest->name;
        $amount = $guest->amount;

        $guest->delete();

        History::create([
            'action' => 'DELETE',
            'target_name' => $name,
            'details' => "បានលុបចោលទិន្នន័យ (ទឹកប្រាក់: \${$amount})",
        ]);

        return back()->with('success', '🗑️ លុបចោលជោគជ័យ!');
    }
}