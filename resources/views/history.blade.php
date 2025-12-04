<!DOCTYPE html>
<html lang="km">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activity Log</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Battambang:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <style>body { font-family: 'Battambang', cursive; }</style>
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="bg-gray-800 text-white p-4 sticky top-0 z-50">
        <div class="max-w-4xl mx-auto flex justify-between items-center">
            <h1 class="font-bold"><i class="fas fa-history"></i> ប្រវត្តិសកម្មភាព</h1>
            <a href="{{ route('home') }}" class="bg-blue-600 px-3 py-1 rounded text-sm hover:bg-blue-500">
                <i class="fas fa-arrow-left"></i> ត្រឡប់ក្រោយ
            </a>
        </div>
    </div>

    <div class="max-w-4xl mx-auto p-4">
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-gray-200 text-gray-600 text-sm">
                    <tr>
                        <th class="p-3">សកម្មភាព</th>
                        <th class="p-3">គោលដៅ</th>
                        <th class="p-3">បរិយាយ</th>
                        <th class="p-3 text-right">ម៉ោង</th>
                    </tr>
                </thead>
                <tbody class="divide-y text-sm">
                    @foreach($histories as $log)
                        <tr class="hover:bg-gray-50">
                            <td class="p-3 font-bold">
                                @if($log->action == 'CREATE') <span class="text-green-600">បង្កើតថ្មី</span>
                                @elseif($log->action == 'UPDATE') <span class="text-yellow-600">កែប្រែ</span>
                                @else <span class="text-red-600">លុបចោល</span> @endif
                            </td>
                            <td class="p-3 font-bold">{{ $log->target_name }}</td>
                            <td class="p-3 text-gray-600">{{ $log->details }}</td>
                            <td class="p-3 text-right text-xs text-gray-400">{{ $log->created_at->format('d-M h:i A') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="p-4">
                {{ $histories->links() }}
            </div>
        </div>
    </div>
</body>
</html>