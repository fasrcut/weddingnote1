<!DOCTYPE html>
<html lang="km">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wedding Book</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Battambang:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    
    <style>
        body { font-family: 'Battambang', cursive; }
        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        
        /* Animation for Modals */
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        .animate-fade-in { animation: fadeIn 0.2s ease-out; }
    </style>
</head>
<body class="bg-gray-100 min-h-screen text-gray-800">

    <div class="bg-blue-900 text-white p-4 shadow-lg sticky top-0 z-40">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <h1 class="text-xl font-bold flex items-center gap-2">
                <i class="fas fa-book-open text-yellow-400"></i> Wedding Book
            </h1>
            <div class="flex items-center gap-3">
                <button onclick="openHistoryModal()" class="text-sm bg-white/10 hover:bg-white/20 text-white px-3 py-2 rounded-lg transition border border-white/20 flex items-center gap-2">
                    <i class="fas fa-history"></i> <span class="hidden sm:inline">ប្រវត្តិ</span>
                </button>
                <div class="text-xs bg-yellow-400 text-blue-900 px-2 py-1 rounded font-bold hidden sm:block shadow">Reception App</div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto p-4 lg:p-6">
        
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
            <div class="bg-white p-5 rounded-xl shadow-md border-b-4 border-green-500 hover:shadow-lg transition">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-500 text-xs uppercase font-bold tracking-wider">ទឹកប្រាក់សរុប</p>
                        <p class="text-3xl font-bold text-green-600 mt-1">${{ number_format($totalMoney, 2) }}</p>
                    </div>
                    <div class="p-2 bg-green-50 rounded-lg text-green-600"><i class="fas fa-dollar-sign text-xl"></i></div>
                </div>
            </div>
            <div class="bg-white p-5 rounded-xl shadow-md border-b-4 border-blue-500 hover:shadow-lg transition">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-500 text-xs uppercase font-bold tracking-wider">ភ្ញៀវសរុប</p>
                        <p class="text-3xl font-bold text-blue-600 mt-1">{{ $totalPeople }} <span class="text-sm text-gray-400 font-normal">នាក់</span></p>
                    </div>
                    <div class="p-2 bg-blue-50 rounded-lg text-blue-600"><i class="fas fa-users text-xl"></i></div>
                </div>
            </div>
            <div class="bg-white p-5 rounded-xl shadow-md border-b-4 border-purple-500 hover:shadow-lg transition">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-500 text-xs uppercase font-bold tracking-wider">ស្រោមសំបុត្រ</p>
                        <p class="text-3xl font-bold text-purple-600 mt-1">{{ $totalEnvelopes }}</p>
                    </div>
                    <div class="p-2 bg-purple-50 rounded-lg text-purple-600"><i class="fas fa-envelope text-xl"></i></div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            
            <div class="lg:col-span-4 h-fit sticky top-24">
                <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100">
                    <h2 class="font-bold text-lg mb-5 text-blue-900 border-b pb-3 flex items-center gap-2">
                        <span class="bg-blue-100 text-blue-600 p-1.5 rounded-md"><i class="fas fa-pen"></i></span> កត់ត្រាថ្មី
                    </h2>
                    
                    <form action="{{ route('save.guest') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                        @csrf
                        
                        <div>
                            <label class="block text-gray-700 font-bold mb-1.5 text-sm">ឈ្មោះអ្នកចងដៃ <span class="text-red-500">*</span></label>
                            <input type="text" name="name" class="w-full border-2 border-gray-200 p-3 rounded-lg focus:border-blue-500 focus:ring-0 outline-none transition bg-gray-50 focus:bg-white" placeholder="បញ្ចូលឈ្មោះ..." required>
                        </div>

                        <div class="flex gap-4">
                            <div class="w-3/5">
                                <label class="block text-gray-700 font-bold mb-1.5 text-sm">ទឹកប្រាក់ ($) <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 font-bold">$</span>
                                    </div>
                                    <input type="number" step="0.01" name="amount" class="w-full border-2 border-gray-200 p-3 pl-7 rounded-lg focus:border-green-500 focus:ring-0 outline-none font-bold text-green-700 text-lg transition bg-gray-50 focus:bg-white" placeholder="0.00" required>
                                </div>
                            </div>
                            <div class="w-2/5">
                                <label class="block text-gray-700 font-bold mb-1.5 text-sm">ចំនួន</label>
                                <select name="guests_count" class="w-full border-2 border-gray-200 p-3 rounded-lg bg-white h-[52px] focus:border-blue-500 outline-none">
                                    <option value="1">1 នាក់</option>
                                    <option value="2">2 នាក់</option>
                                    <option value="3">3 នាក់</option>
                                    <option value="4">4 នាក់</option>
                                    <option value="5">5+ នាក់</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-gray-700 font-bold mb-1.5 text-sm">កំណត់សម្គាល់ (Note)</label>
                            <textarea name="description" rows="2" class="w-full border-2 border-gray-200 p-3 rounded-lg text-sm focus:border-blue-500 focus:ring-0 outline-none transition bg-gray-50 focus:bg-white resize-none" placeholder="ឧ. ក្រុមការងារ..."></textarea>
                        </div>

                        <div class="border-2 border-dashed border-gray-300 p-4 rounded-xl text-center bg-gray-50 relative cursor-pointer hover:bg-blue-50 hover:border-blue-300 transition group">
                            <input type="file" name="photo" accept="image/*" capture="environment" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                            <div class="text-gray-400 group-hover:text-blue-500 transition">
                                <i class="fas fa-camera text-3xl mb-2"></i>
                                <p class="text-xs font-bold">ចុចថតវិក័យបត្រ / ស្រោម</p>
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-blue-700 text-white py-3.5 rounded-xl font-bold text-lg hover:bg-blue-800 shadow-lg shadow-blue-200 transition transform active:scale-[0.98] flex justify-center items-center gap-2">
                            <i class="fas fa-save"></i> រក្សាទុក
                        </button>
                    </form>
                </div>
            </div>

            <div class="lg:col-span-8 bg-white rounded-xl shadow-lg border border-gray-100 flex flex-col h-full min-h-[600px] overflow-hidden">
                
                <div class="bg-gray-50 p-4 border-b border-gray-100 flex flex-wrap justify-between items-center gap-3">
                    <h2 class="font-bold text-gray-700 text-lg flex items-center gap-2">
                        <span class="text-blue-600"><i class="fas fa-list-ul"></i></span> បញ្ជីភ្ញៀវ
                    </h2>
                    
                    <div class="flex bg-white rounded-lg p-1 shadow-sm border border-gray-200">
                        <a href="{{ route('home') }}" class="{{ !request('sort') ? 'bg-blue-100 text-blue-700 font-bold' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-50' }} px-3 py-1.5 rounded-md text-xs transition flex items-center gap-1">
                            <i class="fas fa-clock"></i> ថ្មីៗ
                        </a>
                        <a href="{{ route('home', ['sort' => 'highest']) }}" class="{{ request('sort') == 'highest' ? 'bg-blue-100 text-blue-700 font-bold' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-50' }} px-3 py-1.5 rounded-md text-xs transition flex items-center gap-1">
                            <i class="fas fa-arrow-up"></i> ច្រើនបំផុត
                        </a>
                        <a href="{{ route('home', ['sort' => 'lowest']) }}" class="{{ request('sort') == 'lowest' ? 'bg-blue-100 text-blue-700 font-bold' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-50' }} px-3 py-1.5 rounded-md text-xs transition flex items-center gap-1">
                            <i class="fas fa-arrow-down"></i> តិចបំផុត
                        </a>
                    </div>
                </div>
                
                <div class="overflow-y-auto flex-1 p-0">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-gray-50 text-gray-500 text-xs uppercase sticky top-0 z-10 shadow-sm font-semibold tracking-wider">
                            <tr>
                                <th class="p-4 border-b border-gray-100">ឈ្មោះ & ព័ត៌មាន</th>
                                <th class="p-4 border-b border-gray-100 text-right">ទឹកប្រាក់</th>
                                <th class="p-4 border-b border-gray-100 text-center">រូប</th>
                                <th class="p-4 border-b border-gray-100 text-center w-14">#</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 text-sm">
                            @foreach($guests as $guest)
                                <tr class="hover:bg-blue-50/40 transition group duration-150">
                                    <td class="p-4 align-top">
                                        <div class="font-bold text-gray-800 text-base flex items-center gap-2">
                                            {{ $guest->name }}
                                        </div>
                                        
                                        <div class="text-xs text-gray-400 mt-1.5 flex flex-wrap gap-3 items-center">
                                            <span class="flex items-center gap-1" title="ម៉ោងកត់"><i class="far fa-clock"></i> {{ $guest->created_at->format('h:i A') }}</span>
                                            <span class="flex items-center gap-1" title="ចំនួនមនុស្ស"><i class="fas fa-user-friends"></i> {{ $guest->guests_count }}</span>
                                        </div>
                                        
                                        @if($guest->description)
                                            <div class="mt-2 text-xs text-blue-600 bg-blue-50 px-2 py-1 rounded border border-blue-100 inline-block">
                                                {{ $guest->description }}
                                            </div>
                                        @endif

                                        @if($guest->edited_at)
                                            <div class="mt-2 text-[10px] text-orange-600 font-bold bg-orange-50 px-2 py-0.5 rounded border border-orange-100 inline-flex items-center gap-1 w-fit">
                                                <i class="fas fa-pen-alt"></i> កែ: {{ \Carbon\Carbon::parse($guest->edited_at)->format('h:i A') }}
                                            </div>
                                        @endif
                                    </td>
                                    
                                    <td class="p-4 text-right align-top">
                                        <span class="font-bold text-green-600 text-base bg-green-50 px-2 py-1 rounded-md border border-green-100">
                                            ${{ number_format($guest->amount, 2) }}
                                        </span>
                                    </td>
                                    
                                    <td class="p-4 text-center align-top">
                                        @if($guest->image_path)
                                            <button onclick="showImage('{{ asset('storage/' . $guest->image_path) }}')" class="text-gray-400 hover:text-blue-600 transition transform hover:scale-110 p-1">
                                                <i class="fas fa-image text-xl"></i>
                                            </button>
                                        @else
                                            <span class="text-gray-200 text-lg"><i class="fas fa-image"></i></span>
                                        @endif
                                    </td>

                                    <td class="p-4 text-center align-top relative">
                                        <button onclick="toggleMenu('menu-{{ $guest->id }}')" class="text-gray-300 hover:text-gray-600 p-2 rounded-full hover:bg-gray-100 transition focus:outline-none">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>

                                        <div id="menu-{{ $guest->id }}" class="hidden absolute right-10 top-8 bg-white shadow-2xl rounded-xl border border-gray-100 z-20 w-40 text-left overflow-hidden animate-fade-in ring-1 ring-black ring-opacity-5">
                                            <button onclick="openEditModal({{ $guest }})" class="w-full text-left px-4 py-3 hover:bg-yellow-50 text-gray-700 hover:text-yellow-700 text-sm transition flex items-center gap-2">
                                                <i class="fas fa-edit text-yellow-500"></i> កែប្រែ
                                            </button>
                                            <div class="border-t border-gray-50"></div>
                                            
                                            <form id="delete-form-{{ $guest->id }}" action="{{ route('guest.destroy', $guest->id) }}" method="POST" class="hidden">
                                                @csrf @method('DELETE')
                                            </form>
                                            <button onclick="confirmDelete({{ $guest->id }}, '{{ $guest->name }}')" class="w-full text-left px-4 py-3 hover:bg-red-50 text-gray-700 hover:text-red-600 text-sm transition flex items-center gap-2">
                                                <i class="fas fa-trash-alt text-red-500"></i> លុបចោល
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            
                            @if($guests->isEmpty())
                                <tr>
                                    <td colspan="4" class="p-16 text-center text-gray-400 flex flex-col items-center justify-center">
                                        <div class="bg-gray-50 p-4 rounded-full mb-3">
                                            <i class="fas fa-inbox text-4xl text-gray-300"></i>
                                        </div>
                                        <p class="text-sm font-medium">មិនទាន់មានទិន្នន័យនៅឡើយ</p>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="bg-gray-50 p-3 text-center text-xs text-gray-400 border-t border-gray-100">
                    បង្ហាញ 50 នាក់ចុងក្រោយ
                </div>
            </div>
        </div>
    </div>

    <div id="imageModal" class="fixed inset-0 z-50 bg-black/90 hidden flex items-center justify-center p-4 backdrop-blur-sm animate-fade-in" onclick="closeImage()">
        <div class="relative w-full max-w-4xl h-full flex items-center justify-center">
            <button onclick="closeImage()" class="absolute top-5 right-5 text-white/60 hover:text-white text-4xl font-bold transition">&times;</button>
            <img id="modalImage" src="" class="max-w-full max-h-[90vh] rounded-lg shadow-2xl object-contain border-4 border-white/10">
        </div>
    </div>

    <div id="editModal" class="fixed inset-0 z-50 bg-black/60 hidden flex items-center justify-center p-4 backdrop-blur-sm animate-fade-in">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md mx-auto overflow-hidden transform transition-all scale-100">
            <div class="bg-yellow-500 p-4 flex justify-between items-center text-white shadow-md">
                <h2 class="text-lg font-bold flex items-center gap-2"><i class="fas fa-edit"></i> កែប្រែទិន្នន័យ</h2>
                <button onclick="closeEditModal()" class="text-white/70 hover:text-white text-2xl leading-none">&times;</button>
            </div>
            
            <form id="editForm" method="POST" class="p-6 space-y-4">
                @csrf @method('PUT')
                
                <div>
                    <label class="block text-gray-600 text-xs font-bold mb-1.5 uppercase tracking-wide">ឈ្មោះ</label>
                    <input type="text" name="name" id="edit_name" class="w-full border-2 border-gray-200 p-3 rounded-lg focus:border-yellow-400 focus:ring-0 outline-none transition" required>
                </div>

                <div class="flex gap-4">
                    <div class="w-3/5">
                        <label class="block text-gray-600 text-xs font-bold mb-1.5 uppercase tracking-wide">ទឹកប្រាក់ ($)</label>
                        <input type="number" name="amount" id="edit_amount" step="0.01" class="w-full border-2 border-gray-200 p-3 rounded-lg focus:border-yellow-400 focus:ring-0 outline-none font-bold text-gray-700" required>
                    </div>
                    <div class="w-2/5">
                        <label class="block text-gray-600 text-xs font-bold mb-1.5 uppercase tracking-wide">ចំនួន</label>
                        <select name="guests_count" id="edit_count" class="w-full border-2 border-gray-200 p-3 rounded-lg bg-white focus:border-yellow-400 outline-none">
                            <option value="1">1 នាក់</option>
                            <option value="2">2 នាក់</option>
                            <option value="3">3 នាក់</option>
                            <option value="4">4 នាក់</option>
                            <option value="5">5+ នាក់</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-gray-600 text-xs font-bold mb-1.5 uppercase tracking-wide">Note</label>
                    <textarea name="description" id="edit_desc" rows="3" class="w-full border-2 border-gray-200 p-3 rounded-lg focus:border-yellow-400 focus:ring-0 outline-none transition resize-none"></textarea>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-gray-100 mt-2">
                    <button type="button" onclick="closeEditModal()" class="px-5 py-2.5 bg-gray-100 text-gray-600 rounded-lg hover:bg-gray-200 font-medium transition">បោះបង់</button>
                    <button type="submit" class="px-5 py-2.5 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 shadow-lg shadow-yellow-200 font-bold transition flex items-center gap-2">
                        <i class="fas fa-check"></i> រក្សាទុក
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div id="historyModal" class="fixed inset-0 z-50 bg-black/60 hidden flex items-center justify-center p-4 backdrop-blur-sm animate-fade-in">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-3xl mx-auto overflow-hidden h-[85vh] flex flex-col">
            <div class="bg-gray-800 p-5 flex justify-between items-center text-white shrink-0 shadow-md">
                <h2 class="text-lg font-bold flex items-center gap-2"><i class="fas fa-history text-gray-400"></i> ប្រវត្តិសកម្មភាព</h2>
                <button onclick="closeHistoryModal()" class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center hover:bg-white/20 transition text-white">&times;</button>
            </div>
            
            <div class="flex-1 overflow-y-auto p-0">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-100 text-gray-500 text-xs uppercase sticky top-0 z-10 border-b border-gray-200">
                        <tr>
                            <th class="p-4 font-semibold">សកម្មភាព</th>
                            <th class="p-4 font-semibold">ឈ្មោះ</th>
                            <th class="p-4 font-semibold">បរិយាយ</th>
                            <th class="p-4 font-semibold text-right">កាលបរិច្ឆេទ</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        @foreach($histories as $log)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="p-4 font-bold whitespace-nowrap">
                                    @if($log->action == 'CREATE') 
                                        <span class="text-green-700 bg-green-100 px-2.5 py-1 rounded-md text-xs border border-green-200">បង្កើតថ្មី</span>
                                    @elseif($log->action == 'UPDATE') 
                                        <span class="text-yellow-700 bg-yellow-100 px-2.5 py-1 rounded-md text-xs border border-yellow-200">កែប្រែ</span>
                                    @else 
                                        <span class="text-red-700 bg-red-100 px-2.5 py-1 rounded-md text-xs border border-red-200">លុបចោល</span> 
                                    @endif
                                </td>
                                <td class="p-4 font-bold text-gray-800">{{ $log->target_name }}</td>
                                <td class="p-4 text-gray-600 text-xs leading-relaxed max-w-xs">{{ $log->details }}</td>
                                <td class="p-4 text-right text-xs text-gray-400 whitespace-nowrap">{{ $log->created_at->format('d-M h:i A') }}</td>
                            </tr>
                        @endforeach
                        
                        @if($histories->isEmpty())
                            <tr>
                                <td colspan="4" class="p-10 text-center text-gray-400">គ្មានប្រវត្តិសកម្មភាព</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="p-3 bg-gray-50 border-t border-gray-200 text-center text-xs text-gray-500 shrink-0">
                បង្ហាញ 50 សកម្មភាពចុងក្រោយ
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // --- Menu Toggle Logic ---
        document.addEventListener('click', function(e) {
            // Close menu if clicked outside
            if (!e.target.closest('td.relative')) {
                document.querySelectorAll('[id^="menu-"]').forEach(el => el.classList.add('hidden'));
            }
        });

        function toggleMenu(id) {
            // Close other menus first
            document.querySelectorAll('[id^="menu-"]').forEach(el => {
                if (el.id !== id) el.classList.add('hidden');
            });
            document.getElementById(id).classList.toggle('hidden');
        }

        // --- Modals Logic ---
        
        // Image Modal
        function showImage(src) {
            document.getElementById('modalImage').src = src;
            document.getElementById('imageModal').classList.remove('hidden');
        }
        function closeImage() {
            document.getElementById('imageModal').classList.add('hidden');
        }

        // Edit Modal
        function openEditModal(guest) {
            document.getElementById('editModal').classList.remove('hidden');
            document.getElementById('editForm').action = "/guest/" + guest.id;
            
            // Remove "(Edited)" string for cleaner editing
            let cleanName = guest.name.replace(' (Edited)', '');
            document.getElementById('edit_name').value = cleanName;
            
            document.getElementById('edit_amount').value = guest.amount;
            document.getElementById('edit_count').value = guest.guests_count;
            document.getElementById('edit_desc').value = guest.description || '';
            
            // Close the dropdown menu
            document.getElementById('menu-' + guest.id).classList.add('hidden');
        }
        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }

        // History Modal
        function openHistoryModal() {
            document.getElementById('historyModal').classList.remove('hidden');
        }
        function closeHistoryModal() {
            document.getElementById('historyModal').classList.add('hidden');
        }

        // --- SweetAlert2 Logic ---

        // Success Alert
        @if(session('success'))
            Swal.fire({
                title: 'ជោគជ័យ!',
                text: "{{ session('success') }}",
                icon: 'success',
                confirmButtonText: 'យល់ព្រម',
                confirmButtonColor: '#1d4ed8', // blue-700
                timer: 2000,
                timerProgressBar: true,
                background: '#fff',
                color: '#333'
            });
        @endif

        // Error Alert
        @if($errors->any())
            Swal.fire({
                title: 'សូមពិនិត្យម្តងទៀត!',
                html: '<ul class="text-left text-sm text-red-600 list-disc pl-5">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>',
                icon: 'error',
                confirmButtonText: 'កែតម្រូវ',
                confirmButtonColor: '#d33',
            });
        @endif

        // Delete Confirmation
        function confirmDelete(id, name) {
            // Close menu first
            document.getElementById('menu-' + id).classList.add('hidden');
            
            Swal.fire({
                title: 'តើអ្នកច្បាស់ទេ?',
                html: "អ្នកកំពុងតែលុបឈ្មោះ <b>" + name + "</b> ចេញពីបញ្ជី!<br><span class='text-sm text-red-500'>សកម្មភាពនេះមិនអាចត្រឡប់ក្រោយវិញទេ។</span>",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#94a3b8',
                confirmButtonText: 'បាទ/ចាស, លុបចោល!',
                cancelButtonText: 'រក្សាទុក'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            })
        }
    </script>
</body>
</html>