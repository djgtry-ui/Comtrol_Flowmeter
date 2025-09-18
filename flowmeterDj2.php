<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Kontrol Flowmeter Transfer Bahan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
        
        .progress-ring {
            transform: rotate(-90deg);
        }
        
        .progress-ring-circle {
            transition: stroke-dashoffset 0.35s;
            transform-origin: 50% 50%;
        }
        
        .status-running { animation: pulse 2s infinite; }
        
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }

        .flowmeter-active {
            animation: blink 1s infinite;
        }
        
        @keyframes blink {
            0%, 50% { opacity: 1; }
            51%, 100% { opacity: 0.3; }
        }
        
        .outlet-btn {
            transition: all 0.2s ease;
        }
        
        .outlet-btn:hover {
            transform: translateY(-1px);
        }

        .page {
            display: none;
        }

        .page.active {
            display: block;
        }

        .nav-item {
            transition: all 0.3s ease;
        }

        .nav-item:hover {
            background-color: rgba(59, 130, 246, 0.1);
        }

        .nav-item.active {
            background-color: rgba(59, 130, 246, 0.2);
            border-left: 4px solid #3b82f6;
        }

        .page-content {
            display: none;
        }

        .page-content.active {
            display: block;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-900 via-blue-900 to-slate-800 min-h-screen text-white overflow-hidden">
    <!-- Login Page -->
    <div id="loginPage" class="page active">
        <div class="min-h-screen flex items-center justify-center">
            <div class="bg-white/10 backdrop-blur-sm rounded-xl p-8 border border-white/20 w-full max-w-md">
                <div class="text-center mb-8">
                    <div class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h1 class="text-2xl font-bold text-white mb-2">Sistem Kontrol Flowmeter</h1>
                    <p class="text-blue-200">Silakan login untuk mengakses sistem</p>
                </div>
                
                <form id="loginForm" onsubmit="handleLogin(event)">
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">Username:</label>
                        <input type="text" id="username" required class="w-full bg-slate-800 border border-slate-600 rounded px-3 py-2 text-white focus:border-blue-500 focus:outline-none">
                    </div>
                    
                    <div class="mb-6">
                        <label class="block text-sm font-medium mb-2">Password:</label>
                        <input type="password" id="password" required class="w-full bg-slate-800 border border-slate-600 rounded px-3 py-2 text-white focus:border-blue-500 focus:outline-none">
                    </div>
                    
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded transition duration-200">
                        Login
                    </button>
                </form>
                
                <div class="mt-4 text-center text-sm text-gray-400">
                    <p>Created By Nur Djaya Atmaja</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Application -->
    <div id="mainApp" class="page">
        <!-- Navigation Bar -->
        <nav class="bg-white/10 backdrop-blur-sm border-b border-white/20 px-4 py-3">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-4">
                    <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h1 class="text-lg font-bold">Sistem Kontrol Flowmeter</h1>
                </div>
                
                <div class="flex items-center space-x-4">
                    <button onclick="showPage('Melamin')" class="nav-item px-3 py-2 rounded text-sm font-medium active">
                        Melamin
                    </button>
                    <button onclick="showPage('Politur')" class="nav-item px-3 py-2 rounded text-sm font-medium">
                        Politur
                    </button>
                    <button onclick="showPage('history')" class="nav-item px-3 py-2 rounded text-sm font-medium">
                        Log History
                    </button>
                    <button onclick="logout()" class="bg-red-600 hover:bg-red-700 px-3 py-2 rounded text-sm font-medium">
                        Logout
                    </button>
                </div>
            </div>
        </nav>

        <!-- Dashboard Content -->
        <div id="dashboardContent" class="page-content active">
            <div class="container mx-auto px-2 py-2 h-screen flex flex-col">
                <!-- Header -->
                <div class="text-center mb-3">
                    <h2 class="text-xl font-bold text-white mb-1">PELAYANAN MELAMIN</h2>
                    <p class="text-sm text-blue-200">Transfer Bahan ke Outlet - 8 Unit Flowmeter</p>
                </div>

        <!-- Flowmeter Grid - 4x2 Layout -->
        <div class="grid grid-cols-4 gap-2 flex-1">
            <!-- Flowmeter 1 -->
            <div class="bg-white/10 backdrop-blur-sm rounded-lg p-3 border border-white/20 flex flex-col">
                <div class="flex justify-between items-center mb-2">
                    <h3 class="text-sm font-semibold" id="flowmeter-title-1">Flowmeter 1</h3>
                    <div class="flex space-x-1">
                        <button onclick="startFlow(1)" class="bg-green-600 hover:bg-green-700 px-2 py-1 rounded text-xs font-medium">START</button>
                        <button onclick="stopFlow(1)" class="bg-red-600 hover:bg-red-700 px-2 py-1 rounded text-xs font-medium">STOP</button>
                        <button onclick="resetFlow(1)" class="bg-gray-600 hover:bg-gray-700 px-2 py-1 rounded text-xs font-medium">RESET</button>
                    </div>
                </div>
                
                <div class="mb-2">
                    <label class="block text-xs font-medium mb-1">Bahan:</label>
                    <div class="w-full bg-slate-800 border border-slate-600 rounded px-2 py-1 text-white text-xs font-semibold">
                        LWG 12 Sec
                    </div>
                </div>

                <div class="mb-2">
                    <label class="block text-xs font-medium mb-1">Pilih Outlet:</label>
                    <div id="outlets-1" class="flex flex-wrap gap-1"></div>
                </div>

                <div class="grid grid-cols-2 gap-2 mb-2">
                    <div>
                        <label class="block text-xs font-medium mb-1">Target (L):</label>
                        <input type="number" id="target-1" value="1000" class="w-full bg-slate-800 border border-slate-600 rounded px-2 py-1 text-white text-xs">
                    </div>
                    <div>
                        <label class="block text-xs font-medium mb-1">Aktual (L):</label>
                        <input type="number" id="actual-1" value="0" readonly class="w-full bg-slate-700 border border-slate-600 rounded px-2 py-1 text-gray-300 text-xs">
                    </div>
                </div>

                <div class="flex items-center justify-between mt-auto">
                    <div class="relative w-12 h-12">
                        <svg class="progress-ring w-12 h-12">
                            <circle cx="24" cy="24" r="20" stroke="currentColor" stroke-width="3" fill="transparent" class="text-slate-600"/>
                            <circle id="progress-circle-1" cx="24" cy="24" r="20" stroke="currentColor" stroke-width="3" fill="transparent" 
                                    class="text-blue-400 progress-ring-circle" stroke-dasharray="125.66" stroke-dashoffset="125.66"/>
                        </svg>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <span id="progress-text-1" class="text-xs font-bold">0%</span>
                        </div>
                    </div>
                    <div class="text-right">
                        <div id="status-1" class="text-xs font-semibold text-gray-400">STANDBY</div>
                        <div class="text-xs text-gray-400">Rate: <span id="flowrate-1">0</span> L/min</div>
                    </div>
                </div>
            </div>

            <!-- Flowmeter 2 -->
            <div class="bg-white/10 backdrop-blur-sm rounded-lg p-3 border border-white/20 flex flex-col">
                <div class="flex justify-between items-center mb-2">
                    <h3 class="text-sm font-semibold" id="flowmeter-title-2">Flowmeter 2</h3>
                    <div class="flex space-x-1">
                        <button onclick="startFlow(2)" class="bg-green-600 hover:bg-green-700 px-2 py-1 rounded text-xs font-medium">START</button>
                        <button onclick="stopFlow(2)" class="bg-red-600 hover:bg-red-700 px-2 py-1 rounded text-xs font-medium">STOP</button>
                        <button onclick="resetFlow(2)" class="bg-gray-600 hover:bg-gray-700 px-2 py-1 rounded text-xs font-medium">RESET</button>
                    </div>
                </div>
                
                <div class="mb-2">
                    <label class="block text-xs font-medium mb-1">Bahan:</label>
                    <div class="w-full bg-slate-800 border border-slate-600 rounded px-2 py-1 text-white text-xs font-semibold">
                        RK 410002
                    </div>
                </div>

                <div class="mb-2">
                    <label class="block text-xs font-medium mb-1">Pilih Outlet:</label>
                    <div id="outlets-2" class="flex flex-wrap gap-1"></div>
                </div>

                <div class="grid grid-cols-2 gap-2 mb-2">
                    <div>
                        <label class="block text-xs font-medium mb-1">Target (L):</label>
                        <input type="number" id="target-2" value="800" class="w-full bg-slate-800 border border-slate-600 rounded px-2 py-1 text-white text-xs">
                    </div>
                    <div>
                        <label class="block text-xs font-medium mb-1">Aktual (L):</label>
                        <input type="number" id="actual-2" value="0" readonly class="w-full bg-slate-700 border border-slate-600 rounded px-2 py-1 text-gray-300 text-xs">
                    </div>
                </div>

                <div class="flex items-center justify-between mt-auto">
                    <div class="relative w-12 h-12">
                        <svg class="progress-ring w-12 h-12">
                            <circle cx="24" cy="24" r="20" stroke="currentColor" stroke-width="3" fill="transparent" class="text-slate-600"/>
                            <circle id="progress-circle-2" cx="24" cy="24" r="20" stroke="currentColor" stroke-width="3" fill="transparent" 
                                    class="text-green-400 progress-ring-circle" stroke-dasharray="125.66" stroke-dashoffset="125.66"/>
                        </svg>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <span id="progress-text-2" class="text-xs font-bold">0%</span>
                        </div>
                    </div>
                    <div class="text-right">
                        <div id="status-2" class="text-xs font-semibold text-gray-400">STANDBY</div>
                        <div class="text-xs text-gray-400">Rate: <span id="flowrate-2">0</span> L/min</div>
                    </div>
                </div>
            </div>

            <!-- Flowmeter 3 -->
            <div class="bg-white/10 backdrop-blur-sm rounded-lg p-3 border border-white/20 flex flex-col">
                <div class="flex justify-between items-center mb-2">
                    <h3 class="text-sm font-semibold" id="flowmeter-title-3">Flowmeter 3</h3>
                    <div class="flex space-x-1">
                        <button onclick="startFlow(3)" class="bg-green-600 hover:bg-green-700 px-2 py-1 rounded text-xs font-medium">START</button>
                        <button onclick="stopFlow(3)" class="bg-red-600 hover:bg-red-700 px-2 py-1 rounded text-xs font-medium">STOP</button>
                        <button onclick="resetFlow(3)" class="bg-gray-600 hover:bg-gray-700 px-2 py-1 rounded text-xs font-medium">RESET</button>
                    </div>
                </div>
                
                <div class="mb-2">
                    <label class="block text-xs font-medium mb-1">Bahan:</label>
                    <div class="w-full bg-slate-800 border border-slate-600 rounded px-2 py-1 text-white text-xs font-semibold">
                        RM 40023
                    </div>
                </div>

                <div class="mb-2">
                    <label class="block text-xs font-medium mb-1">Pilih Outlet:</label>
                    <div id="outlets-3" class="flex flex-wrap gap-1"></div>
                </div>

                <div class="grid grid-cols-2 gap-2 mb-2">
                    <div>
                        <label class="block text-xs font-medium mb-1">Target (L):</label>
                        <input type="number" id="target-3" value="1200" class="w-full bg-slate-800 border border-slate-600 rounded px-2 py-1 text-white text-xs">
                    </div>
                    <div>
                        <label class="block text-xs font-medium mb-1">Aktual (L):</label>
                        <input type="number" id="actual-3" value="0" readonly class="w-full bg-slate-700 border border-slate-600 rounded px-2 py-1 text-gray-300 text-xs">
                    </div>
                </div>

                <div class="flex items-center justify-between mt-auto">
                    <div class="relative w-12 h-12">
                        <svg class="progress-ring w-12 h-12">
                            <circle cx="24" cy="24" r="20" stroke="currentColor" stroke-width="3" fill="transparent" class="text-slate-600"/>
                            <circle id="progress-circle-3" cx="24" cy="24" r="20" stroke="currentColor" stroke-width="3" fill="transparent" 
                                    class="text-yellow-400 progress-ring-circle" stroke-dasharray="125.66" stroke-dashoffset="125.66"/>
                        </svg>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <span id="progress-text-3" class="text-xs font-bold">0%</span>
                        </div>
                    </div>
                    <div class="text-right">
                        <div id="status-3" class="text-xs font-semibold text-gray-400">STANDBY</div>
                        <div class="text-xs text-gray-400">Rate: <span id="flowrate-3">0</span> L/min</div>
                    </div>
                </div>
            </div>

            <!-- Flowmeter 4 -->
            <div class="bg-white/10 backdrop-blur-sm rounded-lg p-3 border border-white/20 flex flex-col">
                <div class="flex justify-between items-center mb-2">
                    <h3 class="text-sm font-semibold" id="flowmeter-title-4">Flowmeter 4</h3>
                    <div class="flex space-x-1">
                        <button onclick="startFlow(4)" class="bg-green-600 hover:bg-green-700 px-2 py-1 rounded text-xs font-medium">START</button>
                        <button onclick="stopFlow(4)" class="bg-red-600 hover:bg-red-700 px-2 py-1 rounded text-xs font-medium">STOP</button>
                        <button onclick="resetFlow(4)" class="bg-gray-600 hover:bg-gray-700 px-2 py-1 rounded text-xs font-medium">RESET</button>
                    </div>
                </div>
                
                <div class="mb-2">
                    <label class="block text-xs font-medium mb-1">Bahan:</label>
                    <div class="w-full bg-slate-800 border border-slate-600 rounded px-2 py-1 text-white text-xs font-semibold">
                        TH SMT
                    </div>
                </div>

                <div class="mb-2">
                    <label class="block text-xs font-medium mb-1">Pilih Outlet:</label>
                    <div id="outlets-4" class="flex flex-wrap gap-1"></div>
                </div>

                <div class="grid grid-cols-2 gap-2 mb-2">
                    <div>
                        <label class="block text-xs font-medium mb-1">Target (L):</label>
                        <input type="number" id="target-4" value="600" class="w-full bg-slate-800 border border-slate-600 rounded px-2 py-1 text-white text-xs">
                    </div>
                    <div>
                        <label class="block text-xs font-medium mb-1">Aktual (L):</label>
                        <input type="number" id="actual-4" value="0" readonly class="w-full bg-slate-700 border border-slate-600 rounded px-2 py-1 text-gray-300 text-xs">
                    </div>
                </div>

                <div class="flex items-center justify-between mt-auto">
                    <div class="relative w-12 h-12">
                        <svg class="progress-ring w-12 h-12">
                            <circle cx="24" cy="24" r="20" stroke="currentColor" stroke-width="3" fill="transparent" class="text-slate-600"/>
                            <circle id="progress-circle-4" cx="24" cy="24" r="20" stroke="currentColor" stroke-width="3" fill="transparent" 
                                    class="text-purple-400 progress-ring-circle" stroke-dasharray="125.66" stroke-dashoffset="125.66"/>
                        </svg>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <span id="progress-text-4" class="text-xs font-bold">0%</span>
                        </div>
                    </div>
                    <div class="text-right">
                        <div id="status-4" class="text-xs font-semibold text-gray-400">STANDBY</div>
                        <div class="text-xs text-gray-400">Rate: <span id="flowrate-4">0</span> L/min</div>
                    </div>
                </div>
            </div>

            <!-- Flowmeter 5 -->
            <div class="bg-white/10 backdrop-blur-sm rounded-lg p-3 border border-white/20 flex flex-col">
                <div class="flex justify-between items-center mb-2">
                    <h3 class="text-sm font-semibold" id="flowmeter-title-5">Flowmeter 5</h3>
                    <div class="flex space-x-1">
                        <button onclick="startFlow(5)" class="bg-green-600 hover:bg-green-700 px-2 py-1 rounded text-xs font-medium">START</button>
                        <button onclick="stopFlow(5)" class="bg-red-600 hover:bg-red-700 px-2 py-1 rounded text-xs font-medium">STOP</button>
                        <button onclick="resetFlow(5)" class="bg-gray-600 hover:bg-gray-700 px-2 py-1 rounded text-xs font-medium">RESET</button>
                    </div>
                </div>
                
                <div class="mb-2">
                    <label class="block text-xs font-medium mb-1">Bahan:</label>
                    <div class="w-full bg-slate-800 border border-slate-600 rounded px-2 py-1 text-white text-xs font-semibold">
                        TH P-01
                    </div>
                </div>

                <div class="mb-2">
                    <label class="block text-xs font-medium mb-1">Pilih Outlet:</label>
                    <div id="outlets-5" class="flex flex-wrap gap-1"></div>
                </div>

                <div class="grid grid-cols-2 gap-2 mb-2">
                    <div>
                        <label class="block text-xs font-medium mb-1">Target (L):</label>
                        <input type="number" id="target-5" value="900" class="w-full bg-slate-800 border border-slate-600 rounded px-2 py-1 text-white text-xs">
                    </div>
                    <div>
                        <label class="block text-xs font-medium mb-1">Aktual (L):</label>
                        <input type="number" id="actual-5" value="0" readonly class="w-full bg-slate-700 border border-slate-600 rounded px-2 py-1 text-gray-300 text-xs">
                    </div>
                </div>

                <div class="flex items-center justify-between mt-auto">
                    <div class="relative w-12 h-12">
                        <svg class="progress-ring w-12 h-12">
                            <circle cx="24" cy="24" r="20" stroke="currentColor" stroke-width="3" fill="transparent" class="text-slate-600"/>
                            <circle id="progress-circle-5" cx="24" cy="24" r="20" stroke="currentColor" stroke-width="3" fill="transparent" 
                                    class="text-pink-400 progress-ring-circle" stroke-dasharray="125.66" stroke-dashoffset="125.66"/>
                        </svg>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <span id="progress-text-5" class="text-xs font-bold">0%</span>
                        </div>
                    </div>
                    <div class="text-right">
                        <div id="status-5" class="text-xs font-semibold text-gray-400">STANDBY</div>
                        <div class="text-xs text-gray-400">Rate: <span id="flowrate-5">0</span> L/min</div>
                    </div>
                </div>
            </div>

            <!-- Flowmeter 6 -->
            <div class="bg-white/10 backdrop-blur-sm rounded-lg p-3 border border-white/20 flex flex-col">
                <div class="flex justify-between items-center mb-2">
                    <h3 class="text-sm font-semibold" id="flowmeter-title-6">Flowmeter 6</h3>
                    <div class="flex space-x-1">
                        <button onclick="startFlow(6)" class="bg-green-600 hover:bg-green-700 px-2 py-1 rounded text-xs font-medium">START</button>
                        <button onclick="stopFlow(6)" class="bg-red-600 hover:bg-red-700 px-2 py-1 rounded text-xs font-medium">STOP</button>
                        <button onclick="resetFlow(6)" class="bg-gray-600 hover:bg-gray-700 px-2 py-1 rounded text-xs font-medium">RESET</button>
                    </div>
                </div>
                
                <div class="mb-2">
                    <label class="block text-xs font-medium mb-1">Bahan:</label>
                    <div class="w-full bg-slate-800 border border-slate-600 rounded px-2 py-1 text-white text-xs font-semibold">
                        TH V-05
                    </div>
                </div>

                <div class="mb-2">
                    <label class="block text-xs font-medium mb-1">Pilih Outlet:</label>
                    <div id="outlets-6" class="flex flex-wrap gap-1"></div>
                </div>

                <div class="grid grid-cols-2 gap-2 mb-2">
                    <div>
                        <label class="block text-xs font-medium mb-1">Target (L):</label>
                        <input type="number" id="target-6" value="750" class="w-full bg-slate-800 border border-slate-600 rounded px-2 py-1 text-white text-xs">
                    </div>
                    <div>
                        <label class="block text-xs font-medium mb-1">Aktual (L):</label>
                        <input type="number" id="actual-6" value="0" readonly class="w-full bg-slate-700 border border-slate-600 rounded px-2 py-1 text-gray-300 text-xs">
                    </div>
                </div>

                <div class="flex items-center justify-between mt-auto">
                    <div class="relative w-12 h-12">
                        <svg class="progress-ring w-12 h-12">
                            <circle cx="24" cy="24" r="20" stroke="currentColor" stroke-width="3" fill="transparent" class="text-slate-600"/>
                            <circle id="progress-circle-6" cx="24" cy="24" r="20" stroke="currentColor" stroke-width="3" fill="transparent" 
                                    class="text-indigo-400 progress-ring-circle" stroke-dasharray="125.66" stroke-dashoffset="125.66"/>
                        </svg>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <span id="progress-text-6" class="text-xs font-bold">0%</span>
                        </div>
                    </div>
                    <div class="text-right">
                        <div id="status-6" class="text-xs font-semibold text-gray-400">STANDBY</div>
                        <div class="text-xs text-gray-400">Rate: <span id="flowrate-6">0</span> L/min</div>
                    </div>
                </div>
            </div>

            <!-- Flowmeter 7 -->
            <div class="bg-white/10 backdrop-blur-sm rounded-lg p-3 border border-white/20 flex flex-col">
                <div class="flex justify-between items-center mb-2">
                    <h3 class="text-sm font-semibold" id="flowmeter-title-7">Flowmeter 7</h3>
                    <div class="flex space-x-1">
                        <button onclick="startFlow(7)" class="bg-green-600 hover:bg-green-700 px-2 py-1 rounded text-xs font-medium">START</button>
                        <button onclick="stopFlow(7)" class="bg-red-600 hover:bg-red-700 px-2 py-1 rounded text-xs font-medium">STOP</button>
                        <button onclick="resetFlow(7)" class="bg-gray-600 hover:bg-gray-700 px-2 py-1 rounded text-xs font-medium">RESET</button>
                    </div>
                </div>
                
                <div class="mb-2">
                    <label class="block text-xs font-medium mb-1">Bahan:</label>
                    <div class="w-full bg-slate-800 border border-slate-600 rounded px-2 py-1 text-white text-xs font-semibold">
                        TH P-09
                    </div>
                </div>

                <div class="mb-2">
                    <label class="block text-xs font-medium mb-1">Pilih Outlet:</label>
                    <div id="outlets-7" class="flex flex-wrap gap-1"></div>
                </div>

                <div class="grid grid-cols-2 gap-2 mb-2">
                    <div>
                        <label class="block text-xs font-medium mb-1">Target (L):</label>
                        <input type="number" id="target-7" value="1100" class="w-full bg-slate-800 border border-slate-600 rounded px-2 py-1 text-white text-xs">
                    </div>
                    <div>
                        <label class="block text-xs font-medium mb-1">Aktual (L):</label>
                        <input type="number" id="actual-7" value="0" readonly class="w-full bg-slate-700 border border-slate-600 rounded px-2 py-1 text-gray-300 text-xs">
                    </div>
                </div>

                <div class="flex items-center justify-between mt-auto">
                    <div class="relative w-12 h-12">
                        <svg class="progress-ring w-12 h-12">
                            <circle cx="24" cy="24" r="20" stroke="currentColor" stroke-width="3" fill="transparent" class="text-slate-600"/>
                            <circle id="progress-circle-7" cx="24" cy="24" r="20" stroke="currentColor" stroke-width="3" fill="transparent" 
                                    class="text-orange-400 progress-ring-circle" stroke-dasharray="125.66" stroke-dashoffset="125.66"/>
                        </svg>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <span id="progress-text-7" class="text-xs font-bold">0%</span>
                        </div>
                    </div>
                    <div class="text-right">
                        <div id="status-7" class="text-xs font-semibold text-gray-400">STANDBY</div>
                        <div class="text-xs text-gray-400">Rate: <span id="flowrate-7">0</span> L/min</div>
                    </div>
                </div>
            </div>

            <!-- Flowmeter 8 -->
            <div class="bg-white/10 backdrop-blur-sm rounded-lg p-3 border border-white/20 flex flex-col">
                <div class="flex justify-between items-center mb-2">
                    <h3 class="text-sm font-semibold" id="flowmeter-title-8">Flowmeter 8</h3>
                    <div class="flex space-x-1">
                        <button onclick="startFlow(8)" class="bg-green-600 hover:bg-green-700 px-2 py-1 rounded text-xs font-medium">START</button>
                        <button onclick="stopFlow(8)" class="bg-red-600 hover:bg-red-700 px-2 py-1 rounded text-xs font-medium">STOP</button>
                        <button onclick="resetFlow(8)" class="bg-gray-600 hover:bg-gray-700 px-2 py-1 rounded text-xs font-medium">RESET</button>
                    </div>
                </div>
                
                <div class="mb-2">
                    <label class="block text-xs font-medium mb-1">Bahan:</label>
                    <div class="w-full bg-slate-800 border border-slate-600 rounded px-2 py-1 text-white text-xs font-semibold">
                        TH WF
                    </div>
                </div>

                <div class="mb-2">
                    <label class="block text-xs font-medium mb-1">Pilih Outlet:</label>
                    <div id="outlets-8" class="flex flex-wrap gap-1"></div>
                </div>

                <div class="grid grid-cols-2 gap-2 mb-2">
                    <div>
                        <label class="block text-xs font-medium mb-1">Target (L):</label>
                        <input type="number" id="target-8" value="950" class="w-full bg-slate-800 border border-slate-600 rounded px-2 py-1 text-white text-xs">
                    </div>
                    <div>
                        <label class="block text-xs font-medium mb-1">Aktual (L):</label>
                        <input type="number" id="actual-8" value="0" readonly class="w-full bg-slate-700 border border-slate-600 rounded px-2 py-1 text-gray-300 text-xs">
                    </div>
                </div>

                <div class="flex items-center justify-between mt-auto">
                    <div class="relative w-12 h-12">
                        <svg class="progress-ring w-12 h-12">
                            <circle cx="24" cy="24" r="20" stroke="currentColor" stroke-width="3" fill="transparent" class="text-slate-600"/>
                            <circle id="progress-circle-8" cx="24" cy="24" r="20" stroke="currentColor" stroke-width="3" fill="transparent" 
                                    class="text-teal-400 progress-ring-circle" stroke-dasharray="125.66" stroke-dashoffset="125.66"/>
                        </svg>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <span id="progress-text-8" class="text-xs font-bold">0%</span>
                        </div>
                    </div>
                    <div class="text-right">
                        <div id="status-8" class="text-xs font-semibold text-gray-400">STANDBY</div>
                        <div class="text-xs text-gray-400">Rate: <span id="flowrate-8">0</span> L/min</div>
                    </div>
                </div>
            </div>
        </div>

                <!-- Overall Status -->
                <div class="mt-2 bg-white/10 backdrop-blur-sm rounded-lg p-3 border border-white/20">
                    <h3 class="text-sm font-semibold mb-2">Status Keseluruhan Sistem</h3>
                    <div class="grid grid-cols-4 gap-4">
                        <div class="text-center">
                            <div class="text-lg font-bold text-green-400" id="active-count">0</div>
                            <div class="text-xs text-gray-400">Aktif</div>
                        </div>
                        <div class="text-center">
                            <div class="text-lg font-bold text-yellow-400" id="standby-count">8</div>
                            <div class="text-xs text-gray-400">Standby</div>
                        </div>
                        <div class="text-center">
                            <div class="text-lg font-bold text-blue-400" id="completed-count">0</div>
                            <div class="text-xs text-gray-400">Selesai</div>
                        </div>
                        <div class="text-center">
                            <div class="text-lg font-bold text-white" id="total-flow">0</div>
                            <div class="text-xs text-gray-400">Total Flow (L/min)</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Control 2 Content -->
        <div id="control2Content" class="page-content">
            <div class="container mx-auto px-2 py-2 h-screen flex flex-col">
                <!-- Header -->
                <div class="text-center mb-3">
                    <h2 class="text-xl font-bold text-white mb-1">Politur - Flowmeter 9-13</h2>
                    <p class="text-sm text-blue-200">Transfer Bahan ke Outlet - 5 Unit Flowmeter</p>
                </div>

                <!-- Flowmeter Grid - 5 units in a row -->
                <div class="grid grid-cols-5 gap-2 flex-1">
                    <!-- Flowmeter 9 -->
                    <div class="bg-white/10 backdrop-blur-sm rounded-lg p-3 border border-white/20 flex flex-col">
                        <div class="flex justify-between items-center mb-2">
                            <h3 class="text-sm font-semibold" id="flowmeter-title-9">Flowmeter 9</h3>
                            <div class="flex space-x-1">
                                <button onclick="startFlow(9)" class="bg-green-600 hover:bg-green-700 px-2 py-1 rounded text-xs font-medium">START</button>
                                <button onclick="stopFlow(9)" class="bg-red-600 hover:bg-red-700 px-2 py-1 rounded text-xs font-medium">STOP</button>
                                <button onclick="resetFlow(9)" class="bg-gray-600 hover:bg-gray-700 px-2 py-1 rounded text-xs font-medium">RESET</button>
                            </div>
                        </div>
                        
                        <div class="mb-2">
                            <label class="block text-xs font-medium mb-1">Bahan:</label>
                            <div class="w-full bg-slate-800 border border-slate-600 rounded px-2 py-1 text-white text-xs font-semibold">
                                TH WF2
                            </div>
                        </div>

                        <div class="mb-2">
                            <label class="block text-xs font-medium mb-1">Pilih Outlet:</label>
                            <div id="outlets-9" class="flex flex-wrap gap-1"></div>
                        </div>

                        <div class="grid grid-cols-2 gap-2 mb-2">
                            <div>
                                <label class="block text-xs font-medium mb-1">Target (L):</label>
                                <input type="number" id="target-9" value="850" class="w-full bg-slate-800 border border-slate-600 rounded px-2 py-1 text-white text-xs">
                            </div>
                            <div>
                                <label class="block text-xs font-medium mb-1">Aktual (L):</label>
                                <input type="number" id="actual-9" value="0" readonly class="w-full bg-slate-700 border border-slate-600 rounded px-2 py-1 text-gray-300 text-xs">
                            </div>
                        </div>

                        <div class="flex items-center justify-between mt-auto">
                            <div class="relative w-12 h-12">
                                <svg class="progress-ring w-12 h-12">
                                    <circle cx="24" cy="24" r="20" stroke="currentColor" stroke-width="3" fill="transparent" class="text-slate-600"/>
                                    <circle id="progress-circle-9" cx="24" cy="24" r="20" stroke="currentColor" stroke-width="3" fill="transparent" 
                                            class="text-cyan-400 progress-ring-circle" stroke-dasharray="125.66" stroke-dashoffset="125.66"/>
                                </svg>
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <span id="progress-text-9" class="text-xs font-bold">0%</span>
                                </div>
                            </div>
                            <div class="text-right">
                                <div id="status-9" class="text-xs font-semibold text-gray-400">STANDBY</div>
                                <div class="text-xs text-gray-400">Rate: <span id="flowrate-9">0</span> L/min</div>
                            </div>
                        </div>
                    </div>

                    <!-- Flowmeter 10 -->
                    <div class="bg-white/10 backdrop-blur-sm rounded-lg p-3 border border-white/20 flex flex-col">
                        <div class="flex justify-between items-center mb-2">
                            <h3 class="text-sm font-semibold" id="flowmeter-title-10">Flowmeter 10</h3>
                            <div class="flex space-x-1">
                                <button onclick="startFlow(10)" class="bg-green-600 hover:bg-green-700 px-2 py-1 rounded text-xs font-medium">START</button>
                                <button onclick="stopFlow(10)" class="bg-red-600 hover:bg-red-700 px-2 py-1 rounded text-xs font-medium">STOP</button>
                                <button onclick="resetFlow(10)" class="bg-gray-600 hover:bg-gray-700 px-2 py-1 rounded text-xs font-medium">RESET</button>
                            </div>
                        </div>
                        
                        <div class="mb-2">
                            <label class="block text-xs font-medium mb-1">Bahan:</label>
                            <div class="w-full bg-slate-800 border border-slate-600 rounded px-2 py-1 text-white text-xs font-semibold">
                                TH MS109
                            </div>
                        </div>

                        <div class="mb-2">
                            <label class="block text-xs font-medium mb-1">Pilih Outlet:</label>
                            <div id="outlets-10" class="flex flex-wrap gap-1"></div>
                        </div>

                        <div class="grid grid-cols-2 gap-2 mb-2">
                            <div>
                                <label class="block text-xs font-medium mb-1">Target (L):</label>
                                <input type="number" id="target-10" value="700" class="w-full bg-slate-800 border border-slate-600 rounded px-2 py-1 text-white text-xs">
                            </div>
                            <div>
                                <label class="block text-xs font-medium mb-1">Aktual (L):</label>
                                <input type="number" id="actual-10" value="0" readonly class="w-full bg-slate-700 border border-slate-600 rounded px-2 py-1 text-gray-300 text-xs">
                            </div>
                        </div>

                        <div class="flex items-center justify-between mt-auto">
                            <div class="relative w-12 h-12">
                                <svg class="progress-ring w-12 h-12">
                                    <circle cx="24" cy="24" r="20" stroke="currentColor" stroke-width="3" fill="transparent" class="text-slate-600"/>
                                    <circle id="progress-circle-10" cx="24" cy="24" r="20" stroke="currentColor" stroke-width="3" fill="transparent" 
                                            class="text-lime-400 progress-ring-circle" stroke-dasharray="125.66" stroke-dashoffset="125.66"/>
                                </svg>
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <span id="progress-text-10" class="text-xs font-bold">0%</span>
                                </div>
                            </div>
                            <div class="text-right">
                                <div id="status-10" class="text-xs font-semibold text-gray-400">STANDBY</div>
                                <div class="text-xs text-gray-400">Rate: <span id="flowrate-10">0</span> L/min</div>
                            </div>
                        </div>
                    </div>

                    <!-- Flowmeter 11 -->
                    <div class="bg-white/10 backdrop-blur-sm rounded-lg p-3 border border-white/20 flex flex-col">
                        <div class="flex justify-between items-center mb-2">
                            <h3 class="text-sm font-semibold" id="flowmeter-title-11">Flowmeter 11</h3>
                            <div class="flex space-x-1">
                                <button onclick="startFlow(11)" class="bg-green-600 hover:bg-green-700 px-2 py-1 rounded text-xs font-medium">START</button>
                                <button onclick="stopFlow(11)" class="bg-red-600 hover:bg-red-700 px-2 py-1 rounded text-xs font-medium">STOP</button>
                                <button onclick="resetFlow(11)" class="bg-gray-600 hover:bg-gray-700 px-2 py-1 rounded text-xs font-medium">RESET</button>
                            </div>
                        </div>
                        
                        <div class="mb-2">
                            <label class="block text-xs font-medium mb-1">Bahan:</label>
                            <div class="w-full bg-slate-800 border border-slate-600 rounded px-2 py-1 text-white text-xs font-semibold">
                                TH S04
                            </div>
                        </div>

                        <div class="mb-2">
                            <label class="block text-xs font-medium mb-1">Pilih Outlet:</label>
                            <div id="outlets-11" class="flex flex-wrap gap-1"></div>
                        </div>

                        <div class="grid grid-cols-2 gap-2 mb-2">
                            <div>
                                <label class="block text-xs font-medium mb-1">Target (L):</label>
                                <input type="number" id="target-11" value="1050" class="w-full bg-slate-800 border border-slate-600 rounded px-2 py-1 text-white text-xs">
                            </div>
                            <div>
                                <label class="block text-xs font-medium mb-1">Aktual (L):</label>
                                <input type="number" id="actual-11" value="0" readonly class="w-full bg-slate-700 border border-slate-600 rounded px-2 py-1 text-gray-300 text-xs">
                            </div>
                        </div>

                        <div class="flex items-center justify-between mt-auto">
                            <div class="relative w-12 h-12">
                                <svg class="progress-ring w-12 h-12">
                                    <circle cx="24" cy="24" r="20" stroke="currentColor" stroke-width="3" fill="transparent" class="text-slate-600"/>
                                    <circle id="progress-circle-11" cx="24" cy="24" r="20" stroke="currentColor" stroke-width="3" fill="transparent" 
                                            class="text-emerald-400 progress-ring-circle" stroke-dasharray="125.66" stroke-dashoffset="125.66"/>
                                </svg>
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <span id="progress-text-11" class="text-xs font-bold">0%</span>
                                </div>
                            </div>
                            <div class="text-right">
                                <div id="status-11" class="text-xs font-semibold text-gray-400">STANDBY</div>
                                <div class="text-xs text-gray-400">Rate: <span id="flowrate-11">0</span> L/min</div>
                            </div>
                        </div>
                    </div>

                    <!-- Flowmeter 12 -->
                    <div class="bg-white/10 backdrop-blur-sm rounded-lg p-3 border border-white/20 flex flex-col">
                        <div class="flex justify-between items-center mb-2">
                            <h3 class="text-sm font-semibold" id="flowmeter-title-12">Flowmeter 12</h3>
                            <div class="flex space-x-1">
                                <button onclick="startFlow(12)" class="bg-green-600 hover:bg-green-700 px-2 py-1 rounded text-xs font-medium">START</button>
                                <button onclick="stopFlow(12)" class="bg-red-600 hover:bg-red-700 px-2 py-1 rounded text-xs font-medium">STOP</button>
                                <button onclick="resetFlow(12)" class="bg-gray-600 hover:bg-gray-700 px-2 py-1 rounded text-xs font-medium">RESET</button>
                            </div>
                        </div>
                        
                        <div class="mb-2">
                            <label class="block text-xs font-medium mb-1">Bahan:</label>
                            <div class="w-full bg-slate-800 border border-slate-600 rounded px-2 py-1 text-white text-xs font-semibold">
                                TH Bening
                            </div>
                        </div>

                        <div class="mb-2">
                            <label class="block text-xs font-medium mb-1">Pilih Outlet:</label>
                            <div id="outlets-12" class="flex flex-wrap gap-1"></div>
                        </div>

                        <div class="grid grid-cols-2 gap-2 mb-2">
                            <div>
                                <label class="block text-xs font-medium mb-1">Target (L):</label>
                                <input type="number" id="target-12" value="650" class="w-full bg-slate-800 border border-slate-600 rounded px-2 py-1 text-white text-xs">
                            </div>
                            <div>
                                <label class="block text-xs font-medium mb-1">Aktual (L):</label>
                                <input type="number" id="actual-12" value="0" readonly class="w-full bg-slate-700 border border-slate-600 rounded px-2 py-1 text-gray-300 text-xs">
                            </div>
                        </div>

                        <div class="flex items-center justify-between mt-auto">
                            <div class="relative w-12 h-12">
                                <svg class="progress-ring w-12 h-12">
                                    <circle cx="24" cy="24" r="20" stroke="currentColor" stroke-width="3" fill="transparent" class="text-slate-600"/>
                                    <circle id="progress-circle-12" cx="24" cy="24" r="20" stroke="currentColor" stroke-width="3" fill="transparent" 
                                            class="text-rose-400 progress-ring-circle" stroke-dasharray="125.66" stroke-dashoffset="125.66"/>
                                </svg>
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <span id="progress-text-12" class="text-xs font-bold">0%</span>
                                </div>
                            </div>
                            <div class="text-right">
                                <div id="status-12" class="text-xs font-semibold text-gray-400">STANDBY</div>
                                <div class="text-xs text-gray-400">Rate: <span id="flowrate-12">0</span> L/min</div>
                            </div>
                        </div>
                    </div>

                    <!-- Flowmeter 13 -->
                    <div class="bg-white/10 backdrop-blur-sm rounded-lg p-3 border border-white/20 flex flex-col">
                        <div class="flex justify-between items-center mb-2">
                            <h3 class="text-sm font-semibold" id="flowmeter-title-13">Flowmeter 13</h3>
                            <div class="flex space-x-1">
                                <button onclick="startFlow(13)" class="bg-green-600 hover:bg-green-700 px-2 py-1 rounded text-xs font-medium">START</button>
                                <button onclick="stopFlow(13)" class="bg-red-600 hover:bg-red-700 px-2 py-1 rounded text-xs font-medium">STOP</button>
                                <button onclick="resetFlow(13)" class="bg-gray-600 hover:bg-gray-700 px-2 py-1 rounded text-xs font-medium">RESET</button>
                            </div>
                        </div>
                        
                        <div class="mb-2">
                            <label class="block text-xs font-medium mb-1">Bahan:</label>
                            <div class="w-full bg-slate-800 border border-slate-600 rounded px-2 py-1 text-white text-xs font-semibold">
                                TH Kotor
                            </div>
                        </div>

                        <div class="mb-2">
                            <label class="block text-xs font-medium mb-1">Pilih Outlet:</label>
                            <div id="outlets-13" class="flex flex-wrap gap-1"></div>
                        </div>

                        <div class="grid grid-cols-2 gap-2 mb-2">
                            <div>
                                <label class="block text-xs font-medium mb-1">Target (L):</label>
                                <input type="number" id="target-13" value="800" class="w-full bg-slate-800 border border-slate-600 rounded px-2 py-1 text-white text-xs">
                            </div>
                            <div>
                                <label class="block text-xs font-medium mb-1">Aktual (L):</label>
                                <input type="number" id="actual-13" value="0" readonly class="w-full bg-slate-700 border border-slate-600 rounded px-2 py-1 text-gray-300 text-xs">
                            </div>
                        </div>

                        <div class="flex items-center justify-between mt-auto">
                            <div class="relative w-12 h-12">
                                <svg class="progress-ring w-12 h-12">
                                    <circle cx="24" cy="24" r="20" stroke="currentColor" stroke-width="3" fill="transparent" class="text-slate-600"/>
                                    <circle id="progress-circle-13" cx="24" cy="24" r="20" stroke="currentColor" stroke-width="3" fill="transparent" 
                                            class="text-amber-400 progress-ring-circle" stroke-dasharray="125.66" stroke-dashoffset="125.66"/>
                                </svg>
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <span id="progress-text-13" class="text-xs font-bold">0%</span>
                                </div>
                            </div>
                            <div class="text-right">
                                <div id="status-13" class="text-xs font-semibold text-gray-400">STANDBY</div>
                                <div class="text-xs text-gray-400">Rate: <span id="flowrate-13">0</span> L/min</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Overall Status for Control 2 -->
                <div class="mt-2 bg-white/10 backdrop-blur-sm rounded-lg p-3 border border-white/20">
                    <h3 class="text-sm font-semibold mb-2">Status Keseluruhan Sistem</h3>
                    <div class="grid grid-cols-4 gap-4">
                        <div class="text-center">
                            <div class="text-lg font-bold text-green-400" id="active-count-2">0</div>
                            <div class="text-xs text-gray-400">Aktif</div>
                        </div>
                        <div class="text-center">
                            <div class="text-lg font-bold text-yellow-400" id="standby-count-2">5</div>
                            <div class="text-xs text-gray-400">Standby</div>
                        </div>
                        <div class="text-center">
                            <div class="text-lg font-bold text-blue-400" id="completed-count-2">0</div>
                            <div class="text-xs text-gray-400">Selesai</div>
                        </div>
                        <div class="text-center">
                            <div class="text-lg font-bold text-white" id="total-flow-2">0</div>
                            <div class="text-xs text-gray-400">Total Flow (L/min)</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- History Content -->
        <div id="historyContent" class="page-content">
            <div class="container mx-auto px-4 py-4 h-screen flex flex-col">
                <div class="text-center mb-4">
                    <h2 class="text-xl font-bold text-white mb-1">Log History</h2>
                    <p class="text-sm text-blue-200">Riwayat Transfer Bahan Flowmeter</p>
                </div>

                <!-- Filter Controls -->
                <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4 border border-white/20 mb-4">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-sm font-medium mb-1">Tanggal Mulai:</label>
                            <input type="date" id="startDate" class="w-full bg-slate-800 border border-slate-600 rounded px-3 py-2 text-white text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Tanggal Akhir:</label>
                            <input type="date" id="endDate" class="w-full bg-slate-800 border border-slate-600 rounded px-3 py-2 text-white text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Flowmeter:</label>
                            <select id="flowmeterFilter" class="w-full bg-slate-800 border border-slate-600 rounded px-3 py-2 text-white text-sm">
                                <option value="">Semua</option>
                                <option value="1">Flowmeter 1</option>
                                <option value="2">Flowmeter 2</option>
                                <option value="3">Flowmeter 3</option>
                                <option value="4">Flowmeter 4</option>
                                <option value="5">Flowmeter 5</option>
                                <option value="6">Flowmeter 6</option>
                                <option value="7">Flowmeter 7</option>
                                <option value="8">Flowmeter 8</option>
                                <option value="9">Flowmeter 9</option>
                                <option value="10">Flowmeter 10</option>
                                <option value="11">Flowmeter 11</option>
                                <option value="12">Flowmeter 12</option>
                                <option value="13">Flowmeter 13</option>
                            </select>
                        </div>
                        <div class="flex items-end space-x-2">
                            <button onclick="filterHistory()" class="flex-1 bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded text-sm font-medium">
                                Filter
                            </button>
                            <button onclick="downloadCSV()" class="bg-green-600 hover:bg-green-700 px-4 py-2 rounded text-sm font-medium whitespace-nowrap">
                                📥 CSV
                            </button>
                            <button onclick="downloadExcel()" class="bg-emerald-600 hover:bg-emerald-700 px-4 py-2 rounded text-sm font-medium whitespace-nowrap">
                                📊 Excel
                            </button>
                        </div>
                    </div>
                </div>

                <!-- History Table -->
                <div class="bg-white/10 backdrop-blur-sm rounded-lg border border-white/20 flex-1 overflow-hidden">
                    <div class="p-4 border-b border-white/20">
                        <h3 class="text-lg font-semibold">Riwayat Transfer</h3>
                    </div>
                    <div class="overflow-auto h-full">
                        <table class="w-full text-sm">
                            <thead class="bg-white/5 sticky top-0">
                                <tr>
                                    <th class="px-4 py-3 text-left">Waktu</th>
                                    <th class="px-4 py-3 text-left">Flowmeter</th>
                                    <th class="px-4 py-3 text-left">Bahan</th>
                                    <th class="px-4 py-3 text-left">Outlet</th>
                                    <th class="px-4 py-3 text-left">Target (L)</th>
                                    <th class="px-4 py-3 text-left">Aktual (L)</th>
                                    <th class="px-4 py-3 text-left">Status</th>
                                    <th class="px-4 py-3 text-left">Durasi</th>
                                </tr>
                            </thead>
                            <tbody id="historyTableBody">
                                <!-- History data will be populated here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Authentication and Navigation
        let currentUser = null;
        let currentPage = 'Melamin';
        let transferHistory = [];
        
        // Database configuration
        const DB_CONFIG = {
            host: '192.168.6.221',
            user: 'djaya',
            password: 'root',
            database: 'flowmeter'
        };
        
        // Database simulation (in real implementation, this would be API calls)
        let flowmeterStatusDB = {};
        let machineStatusDB = {};

        // Login functionality
        function handleLogin(event) {
            event.preventDefault();
            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;
            
            // Simple demo authentication
            if (username === 'djaya' && password === 'djaya123') {
                currentUser = username;
                showMainApp();
            } else {
                alert('Username atau password salah!');
            }
        }

        // Show main application
        function showMainApp() {
            document.getElementById('loginPage').classList.remove('active');
            document.getElementById('mainApp').classList.add('active');
            initializeSystem();
        }

        // Logout functionality
        function logout() {
            currentUser = null;
            document.getElementById('mainApp').classList.remove('active');
            document.getElementById('loginPage').classList.add('active');
            document.getElementById('username').value = '';
            document.getElementById('password').value = '';
        }

        // Page navigation
        function showPage(pageName) {
            // Update navigation active state
            document.querySelectorAll('.nav-item').forEach(item => {
                item.classList.remove('active');
            });
            event.target.classList.add('active');

            // Show/hide page content
            document.querySelectorAll('.page-content').forEach(content => {
                content.classList.remove('active');
            });

            if (pageName === 'Melamin') {
                document.getElementById('dashboardContent').classList.add('active');
            } else if (pageName === 'Politur') {
                document.getElementById('control2Content').classList.add('active');
            } else if (pageName === 'history') {
                document.getElementById('historyContent').classList.add('active');
                loadHistory();
            }

            currentPage = pageName;
        }

        // Fixed materials for each flowmeter
        const flowmeterMaterials = {
            1: 'LWG 12 Sec',
            2: 'RK 410002', 
            3: 'RM 40023',
            4: 'TH SMT',
            5: 'TH P-01',
            6: 'TH V-05',
            7: 'TH P-09',
            8: 'TH WF',
            9: 'TH WF2',
            10: 'TH MS109',
            11: 'TH S04',
            12: 'TH Bening',
            13: 'TH Kotor'
        };

        // All flowmeters have 10 outlets
        const outletCount = 10;

        // Flowmeter states
        const flowmeters = {};
        for (let i = 1; i <= 13; i++) {
            flowmeters[i] = {
                running: false,
                actual: 0,
                selectedOutlet: null,
                interval: null,
                flowRate: 0,
                material: flowmeterMaterials[i],
                startTime: null,
                endTime: null
            };
        }

        // Initialize outlet buttons for all flowmeters
        function initializeOutlets() {
            for (let i = 1; i <= 13; i++) {
                createOutlets(i);
            }
        }

        // Create outlet buttons (10 outlets for each flowmeter)
        function createOutlets(flowmeterId) {
            const outletsContainer = document.getElementById(`outlets-${flowmeterId}`);
            outletsContainer.innerHTML = '';
            
            for (let i = 1; i <= outletCount; i++) {
                const button = document.createElement('button');
                button.className = 'outlet-btn bg-slate-700 hover:bg-blue-600 px-1 py-0.5 rounded text-xs border border-slate-500';
                button.textContent = `${i}`;
                button.onclick = () => selectOutlet(flowmeterId, i);
                outletsContainer.appendChild(button);
            }
            
            // Reset selected outlet
            flowmeters[flowmeterId].selectedOutlet = null;
        }

        // Select outlet
        function selectOutlet(flowmeterId, outletNumber) {
            const outletsContainer = document.getElementById(`outlets-${flowmeterId}`);
            const buttons = outletsContainer.querySelectorAll('button');
            
            // Reset all buttons
            buttons.forEach(btn => {
                btn.className = 'outlet-btn bg-slate-700 hover:bg-blue-600 px-1 py-0.5 rounded text-xs border border-slate-500';
            });
            
            // Highlight selected button
            buttons[outletNumber - 1].className = 'outlet-btn bg-blue-600 px-1 py-0.5 rounded text-xs border border-blue-400';
            
            flowmeters[flowmeterId].selectedOutlet = outletNumber;
        }

        // Database API functions
        async function sendToDatabase(endpoint, data) {
            try {
                // In real implementation, this would be actual API call to your backend
                const response = await fetch(`http://${DB_CONFIG.host}/api/${endpoint}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${currentUser}`
                    },
                    body: JSON.stringify(data)
                });
                
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                
                const result = await response.json();
                return result;
            } catch (error) {
                console.error('Database API Error:', error);
                // Fallback to local storage for demo
                return simulateDBUpdate(endpoint, data);
            }
        }

        // Simulate database update for demo purposes
        function simulateDBUpdate(endpoint, data) {
            console.log(`📡 API Call to: ${endpoint}`);
            console.log('📊 Data sent:', data);
            
            // Store in local simulation
            if (endpoint === 'flowmeter-status') {
                flowmeterStatusDB[data.flowmeter_id] = data;
            } else if (endpoint === 'machine-status') {
                machineStatusDB[data.machine_id] = data;
            }
            
            return { success: true, message: 'Data updated successfully' };
        }

        // Database update functions
        async function updateFlowmeterStatusDB(flowmeterId, action, data = {}) {
            const timestamp = new Date().toISOString();
            const target = parseFloat(document.getElementById(`target-${flowmeterId}`).value) || 0;
            const actual = Math.round(flowmeters[flowmeterId].actual) || 0;
            
            // Prepare flowmeter status data
            const flowmeterData = {
                flowmeter_id: flowmeterId,
                material: flowmeters[flowmeterId].material,
                outlet: flowmeters[flowmeterId].selectedOutlet,
                target_volume: target,
                actual_volume: actual,
                status: action,
                flow_rate: flowmeters[flowmeterId].flowRate || 0,
                user_id: currentUser,
                last_updated: timestamp,
                start_time: flowmeters[flowmeterId].startTime ? flowmeters[flowmeterId].startTime.toISOString() : null,
                end_time: flowmeters[flowmeterId].endTime ? flowmeters[flowmeterId].endTime.toISOString() : null,
                ...data
            };
            
            // Prepare machine status data
            const machineData = {
                machine_id: flowmeterId,
                machine_name: `Flowmeter ${flowmeterId}`,
                is_online: true,
                is_running: action === 'RUNNING',
                current_status: action,
                button_start: action === 'RUNNING',
                button_stop: action === 'STOPPED',
                button_reset: action === 'STANDBY',
                target_value: target,
                actual_value: actual,
                user_operator: currentUser,
                last_activity: timestamp,
                session_id: `session_${flowmeterId}_${Date.now()}`
            };
            
            // Send to database
            try {
                const flowmeterResult = await sendToDatabase('flowmeter-status', flowmeterData);
                const machineResult = await sendToDatabase('machine-status', machineData);
                
                console.log(`✅ Flowmeter ${flowmeterId} - Database updated:`, {
                    flowmeter: flowmeterResult,
                    machine: machineResult
                });
                
                // Update UI status indicator
                updateDBStatusIndicator(flowmeterId, true);
                
            } catch (error) {
                console.error(`❌ Database update failed for Flowmeter ${flowmeterId}:`, error);
                updateDBStatusIndicator(flowmeterId, false);
            }
        }

        // Update database status indicator in UI
        function updateDBStatusIndicator(flowmeterId, success) {
            const titleElement = document.getElementById(`flowmeter-title-${flowmeterId}`);
            if (titleElement) {
                // Remove existing indicators
                titleElement.classList.remove('db-success', 'db-error');
                
                // Add new indicator
                if (success) {
                    titleElement.classList.add('db-success');
                    titleElement.style.borderLeft = '3px solid #10B981';
                } else {
                    titleElement.classList.add('db-error');
                    titleElement.style.borderLeft = '3px solid #EF4444';
                }
                
                // Remove indicator after 3 seconds
                setTimeout(() => {
                    titleElement.classList.remove('db-success', 'db-error');
                    titleElement.style.borderLeft = '';
                }, 3000);
            }
        }

        // Start flow
        function startFlow(flowmeterId) {
            if (!flowmeters[flowmeterId].selectedOutlet) {
                alert('Pilih outlet terlebih dahulu!');
                return;
            }
            
            if (flowmeters[flowmeterId].running) return;
            
            flowmeters[flowmeterId].running = true;
            flowmeters[flowmeterId].flowRate = Math.random() * 20 + 10; // 10-30 L/min
            flowmeters[flowmeterId].startTime = new Date();
            
            const statusElement = document.getElementById(`status-${flowmeterId}`);
            statusElement.textContent = 'RUNNING';
            statusElement.className = 'text-xs font-semibold text-green-400 status-running';
            
            // Add blinking animation to flowmeter title
            const titleElement = document.getElementById(`flowmeter-title-${flowmeterId}`);
            if (titleElement) {
                titleElement.classList.add('flowmeter-active');
            }
            
            // Update database
            updateFlowmeterStatusDB(flowmeterId, 'RUNNING');
            
            // Start simulation
            flowmeters[flowmeterId].interval = setInterval(() => {
                simulateFlow(flowmeterId);
            }, 100);
            
            updateOverallStatus();
        }

        // Stop flow
        function stopFlow(flowmeterId) {
            if (!flowmeters[flowmeterId].running) return;
            
            flowmeters[flowmeterId].running = false;
            flowmeters[flowmeterId].flowRate = 0;
            flowmeters[flowmeterId].endTime = new Date();
            
            if (flowmeters[flowmeterId].interval) {
                clearInterval(flowmeters[flowmeterId].interval);
                flowmeters[flowmeterId].interval = null;
            }
            
            const statusElement = document.getElementById(`status-${flowmeterId}`);
            statusElement.textContent = 'STOPPED';
            statusElement.className = 'text-xs font-semibold text-red-400';
            
            // Remove blinking animation from flowmeter title
            const titleElement = document.getElementById(`flowmeter-title-${flowmeterId}`);
            if (titleElement) {
                titleElement.classList.remove('flowmeter-active');
            }
            
            document.getElementById(`flowrate-${flowmeterId}`).textContent = '0';
            
            // Update database
            updateFlowmeterStatusDB(flowmeterId, 'STOPPED');
            
            // Log to history
            logTransferHistory(flowmeterId, 'STOPPED');
            
            updateOverallStatus();
        }

        // Reset flow
        function resetFlow(flowmeterId) {
            stopFlow(flowmeterId);
            
            flowmeters[flowmeterId].actual = 0;
            flowmeters[flowmeterId].startTime = null;
            flowmeters[flowmeterId].endTime = null;
            document.getElementById(`actual-${flowmeterId}`).value = 0;
            
            const statusElement = document.getElementById(`status-${flowmeterId}`);
            statusElement.textContent = 'STANDBY';
            statusElement.className = 'text-xs font-semibold text-gray-400';
            
            // Remove blinking animation from flowmeter title
            const titleElement = document.getElementById(`flowmeter-title-${flowmeterId}`);
            if (titleElement) {
                titleElement.classList.remove('flowmeter-active');
            }
            
            // Update database
            updateFlowmeterStatusDB(flowmeterId, 'STANDBY');
            
            updateProgress(flowmeterId, 0);
            updateOverallStatus();
        }

        // Simulate flow
        function simulateFlow(flowmeterId) {
            const target = parseFloat(document.getElementById(`target-${flowmeterId}`).value);
            const increment = flowmeters[flowmeterId].flowRate / 600; // Convert L/min to L per 100ms
            
            flowmeters[flowmeterId].actual += increment;
            
            if (flowmeters[flowmeterId].actual >= target) {
                flowmeters[flowmeterId].actual = target;
                flowmeters[flowmeterId].running = false;
                flowmeters[flowmeterId].flowRate = 0;
                flowmeters[flowmeterId].endTime = new Date();
                
                if (flowmeters[flowmeterId].interval) {
                    clearInterval(flowmeters[flowmeterId].interval);
                    flowmeters[flowmeterId].interval = null;
                }
                
                const statusElement = document.getElementById(`status-${flowmeterId}`);
                statusElement.textContent = 'COMPLETED';
                statusElement.className = 'text-xs font-semibold text-blue-400';
                
                // Remove blinking animation from flowmeter title
                const titleElement = document.getElementById(`flowmeter-title-${flowmeterId}`);
                if (titleElement) {
                    titleElement.classList.remove('flowmeter-active');
                }
                
                // Update database for completion
                updateFlowmeterStatusDB(flowmeterId, 'COMPLETED');
                
                // Log to history
                logTransferHistory(flowmeterId, 'COMPLETED');
                
                updateOverallStatus();
            }
            
            document.getElementById(`actual-${flowmeterId}`).value = Math.round(flowmeters[flowmeterId].actual);
            document.getElementById(`flowrate-${flowmeterId}`).textContent = flowmeters[flowmeterId].flowRate.toFixed(1);
            
            const progress = (flowmeters[flowmeterId].actual / target) * 100;
            updateProgress(flowmeterId, Math.min(progress, 100));
            
            // Update database every 5 seconds during operation (every 50 intervals of 100ms)
            if (Math.floor(flowmeters[flowmeterId].actual * 10) % 50 === 0) {
                updateFlowmeterStatusDB(flowmeterId, 'RUNNING');
            }
        }

        // Update progress circle
        function updateProgress(flowmeterId, percentage) {
            const circle = document.getElementById(`progress-circle-${flowmeterId}`);
            const text = document.getElementById(`progress-text-${flowmeterId}`);
            
            const circumference = 2 * Math.PI * 20;
            const offset = circumference - (percentage / 100) * circumference;
            
            circle.style.strokeDashoffset = offset;
            text.textContent = `${Math.round(percentage)}%`;
        }

        // Update overall status
        function updateOverallStatus() {
            // Dashboard (Flowmeters 1-8)
            let activeCount = 0;
            let standbyCount = 0;
            let completedCount = 0;
            let totalFlow = 0;
            
            for (let i = 1; i <= 8; i++) {
                const statusElement = document.getElementById(`status-${i}`);
                if (statusElement) {
                    const status = statusElement.textContent;
                    
                    if (status === 'RUNNING') {
                        activeCount++;
                        totalFlow += flowmeters[i].flowRate;
                    } else if (status === 'COMPLETED') {
                        completedCount++;
                    } else {
                        standbyCount++;
                    }
                }
            }
            
            const activeCountEl = document.getElementById('active-count');
            const standbyCountEl = document.getElementById('standby-count');
            const completedCountEl = document.getElementById('completed-count');
            const totalFlowEl = document.getElementById('total-flow');
            
            if (activeCountEl) activeCountEl.textContent = activeCount;
            if (standbyCountEl) standbyCountEl.textContent = standbyCount;
            if (completedCountEl) completedCountEl.textContent = completedCount;
            if (totalFlowEl) totalFlowEl.textContent = totalFlow.toFixed(1);
            
            // Control 2 (Flowmeters 9-13)
            let activeCount2 = 0;
            let standbyCount2 = 0;
            let completedCount2 = 0;
            let totalFlow2 = 0;
            
            for (let i = 9; i <= 13; i++) {
                const statusElement = document.getElementById(`status-${i}`);
                if (statusElement) {
                    const status = statusElement.textContent;
                    
                    if (status === 'RUNNING') {
                        activeCount2++;
                        totalFlow2 += flowmeters[i].flowRate;
                    } else if (status === 'COMPLETED') {
                        completedCount2++;
                    } else {
                        standbyCount2++;
                    }
                }
            }
            
            const activeCount2El = document.getElementById('active-count-2');
            const standbyCount2El = document.getElementById('standby-count-2');
            const completedCount2El = document.getElementById('completed-count-2');
            const totalFlow2El = document.getElementById('total-flow-2');
            
            if (activeCount2El) activeCount2El.textContent = activeCount2;
            if (standbyCount2El) standbyCount2El.textContent = standbyCount2;
            if (completedCount2El) completedCount2El.textContent = completedCount2;
            if (totalFlow2El) totalFlow2El.textContent = totalFlow2.toFixed(1);
        }

        // Log transfer to history
        function logTransferHistory(flowmeterId, status) {
            const target = parseFloat(document.getElementById(`target-${flowmeterId}`).value);
            const actual = flowmeters[flowmeterId].actual;
            const startTime = flowmeters[flowmeterId].startTime;
            const endTime = flowmeters[flowmeterId].endTime;
            const duration = endTime ? Math.round((endTime - startTime) / 1000) : 0;
            
            const historyEntry = {
                id: Date.now(),
                timestamp: startTime,
                flowmeter: flowmeterId,
                material: flowmeters[flowmeterId].material,
                outlet: flowmeters[flowmeterId].selectedOutlet,
                target: target,
                actual: Math.round(actual),
                status: status,
                duration: duration,
                user: currentUser
            };
            
            transferHistory.unshift(historyEntry);
            
            // Keep only last 100 entries
            if (transferHistory.length > 100) {
                transferHistory = transferHistory.slice(0, 100);
            }
        }

        // Load and display history
        function loadHistory() {
            const tbody = document.getElementById('historyTableBody');
            tbody.innerHTML = '';
            
            if (transferHistory.length === 0) {
                tbody.innerHTML = '<tr><td colspan="8" class="px-4 py-8 text-center text-gray-400">Belum ada data history</td></tr>';
                return;
            }
            
            transferHistory.forEach(entry => {
                const row = document.createElement('tr');
                row.className = 'border-b border-white/10 hover:bg-white/5';
                
                const statusClass = entry.status === 'COMPLETED' ? 'text-green-400' : 
                                  entry.status === 'STOPPED' ? 'text-red-400' : 'text-yellow-400';
                
                row.innerHTML = `
                    <td class="px-4 py-3">${entry.timestamp.toLocaleString('id-ID')}</td>
                    <td class="px-4 py-3">Flowmeter ${entry.flowmeter}</td>
                    <td class="px-4 py-3">${entry.material}</td>
                    <td class="px-4 py-3">Outlet ${entry.outlet}</td>
                    <td class="px-4 py-3">${entry.target}</td>
                    <td class="px-4 py-3">${entry.actual}</td>
                    <td class="px-4 py-3"><span class="${statusClass}">${entry.status}</span></td>
                    <td class="px-4 py-3">${entry.duration}s</td>
                `;
                
                tbody.appendChild(row);
            });
        }

        // Filter history
        function filterHistory() {
            const startDate = document.getElementById('startDate').value;
            const endDate = document.getElementById('endDate').value;
            const flowmeterFilter = document.getElementById('flowmeterFilter').value;
            
            let filteredHistory = [...transferHistory];
            
            if (startDate) {
                const start = new Date(startDate);
                filteredHistory = filteredHistory.filter(entry => entry.timestamp >= start);
            }
            
            if (endDate) {
                const end = new Date(endDate);
                end.setHours(23, 59, 59, 999);
                filteredHistory = filteredHistory.filter(entry => entry.timestamp <= end);
            }
            
            if (flowmeterFilter) {
                filteredHistory = filteredHistory.filter(entry => entry.flowmeter == flowmeterFilter);
            }
            
            displayFilteredHistory(filteredHistory);
        }

        // Display filtered history
        function displayFilteredHistory(filteredData) {
            const tbody = document.getElementById('historyTableBody');
            tbody.innerHTML = '';
            
            if (filteredData.length === 0) {
                tbody.innerHTML = '<tr><td colspan="8" class="px-4 py-8 text-center text-gray-400">Tidak ada data yang sesuai filter</td></tr>';
                return;
            }
            
            filteredData.forEach(entry => {
                const row = document.createElement('tr');
                row.className = 'border-b border-white/10 hover:bg-white/5';
                
                const statusClass = entry.status === 'COMPLETED' ? 'text-green-400' : 
                                  entry.status === 'STOPPED' ? 'text-red-400' : 'text-yellow-400';
                
                row.innerHTML = `
                    <td class="px-4 py-3">${entry.timestamp.toLocaleString('id-ID')}</td>
                    <td class="px-4 py-3">Flowmeter ${entry.flowmeter}</td>
                    <td class="px-4 py-3">${entry.material}</td>
                    <td class="px-4 py-3">Outlet ${entry.outlet}</td>
                    <td class="px-4 py-3">${entry.target}</td>
                    <td class="px-4 py-3">${entry.actual}</td>
                    <td class="px-4 py-3"><span class="${statusClass}">${entry.status}</span></td>
                    <td class="px-4 py-3">${entry.duration}s</td>
                `;
                
                tbody.appendChild(row);
            });
        }

        // Initialize system after login
        function initializeSystem() {
            initializeOutlets();
            updateOverallStatus();
            
            // Set default dates for history filter
            const today = new Date();
            const weekAgo = new Date(today.getTime() - 7 * 24 * 60 * 60 * 1000);
            
            document.getElementById('startDate').value = weekAgo.toISOString().split('T')[0];
            document.getElementById('endDate').value = today.toISOString().split('T')[0];
        }

        // Download history as CSV
        function downloadCSV() {
            const data = getCurrentHistoryData();
            
            if (data.length === 0) {
                alert('Tidak ada data untuk didownload');
                return;
            }
            
            // CSV headers
            const headers = ['Waktu', 'Flowmeter', 'Bahan', 'Outlet', 'Target (L)', 'Aktual (L)', 'Status', 'Durasi (s)', 'User'];
            
            // Convert data to CSV format
            let csvContent = headers.join(',') + '\n';
            
            data.forEach(entry => {
                const row = [
                    `"${entry.timestamp.toLocaleString('id-ID')}"`,
                    `"Flowmeter ${entry.flowmeter}"`,
                    `"${entry.material}"`,
                    `"Outlet ${entry.outlet}"`,
                    entry.target,
                    entry.actual,
                    `"${entry.status}"`,
                    entry.duration,
                    `"${entry.user}"`
                ];
                csvContent += row.join(',') + '\n';
            });
            
            // Create and download file
            const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
            const link = document.createElement('a');
            const url = URL.createObjectURL(blob);
            link.setAttribute('href', url);
            link.setAttribute('download', `flowmeter_history_${new Date().toISOString().split('T')[0]}.csv`);
            link.style.visibility = 'hidden';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }

        // Download history as Excel
        function downloadExcel() {
            const data = getCurrentHistoryData();
            
            if (data.length === 0) {
                alert('Tidak ada data untuk didownload');
                return;
            }
            
            // Create Excel content using HTML table format
            let excelContent = `
                <html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">
                <head>
                    <meta charset="utf-8">
                    <!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>Flowmeter History</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]-->
                </head>
                <body>
                    <table border="1">
                        <thead>
                            <tr style="background-color: #4F46E5; color: white; font-weight: bold;">
                                <th>Waktu</th>
                                <th>Flowmeter</th>
                                <th>Bahan</th>
                                <th>Outlet</th>
                                <th>Target (L)</th>
                                <th>Aktual (L)</th>
                                <th>Status</th>
                                <th>Durasi (s)</th>
                                <th>User</th>
                            </tr>
                        </thead>
                        <tbody>
            `;
            
            data.forEach(entry => {
                const statusColor = entry.status === 'COMPLETED' ? '#10B981' : 
                                  entry.status === 'STOPPED' ? '#EF4444' : '#F59E0B';
                
                excelContent += `
                    <tr>
                        <td>${entry.timestamp.toLocaleString('id-ID')}</td>
                        <td>Flowmeter ${entry.flowmeter}</td>
                        <td>${entry.material}</td>
                        <td>Outlet ${entry.outlet}</td>
                        <td>${entry.target}</td>
                        <td>${entry.actual}</td>
                        <td style="color: ${statusColor}; font-weight: bold;">${entry.status}</td>
                        <td>${entry.duration}</td>
                        <td>${entry.user}</td>
                    </tr>
                `;
            });
            
            excelContent += `
                        </tbody>
                    </table>
                </body>
                </html>
            `;
            
            // Create and download file
            const blob = new Blob([excelContent], { type: 'application/vnd.ms-excel' });
            const link = document.createElement('a');
            const url = URL.createObjectURL(blob);
            link.setAttribute('href', url);
            link.setAttribute('download', `flowmeter_history_${new Date().toISOString().split('T')[0]}.xlsx`);
            link.style.visibility = 'hidden';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }

        // Get current history data (filtered or all)
        function getCurrentHistoryData() {
            const startDate = document.getElementById('startDate').value;
            const endDate = document.getElementById('endDate').value;
            const flowmeterFilter = document.getElementById('flowmeterFilter').value;
            
            let data = [...transferHistory];
            
            // Apply filters if any
            if (startDate) {
                const start = new Date(startDate);
                data = data.filter(entry => entry.timestamp >= start);
            }
            
            if (endDate) {
                const end = new Date(endDate);
                end.setHours(23, 59, 59, 999);
                data = data.filter(entry => entry.timestamp <= end);
            }
            
            if (flowmeterFilter) {
                data = data.filter(entry => entry.flowmeter == flowmeterFilter);
            }
            
            return data;
        }

        // Initialize the system
        document.addEventListener('DOMContentLoaded', function() {
            // System starts with login page
        });
    </script>
<script>(function(){function c(){var b=a.contentDocument||a.contentWindow.document;if(b){var d=b.createElement('script');d.innerHTML="window.__CF$cv$params={r:'9758e36494503e5b',t:'MTc1NjI2OTU5OS4wMDAwMDA='};var a=document.createElement('script');a.nonce='';a.src='/cdn-cgi/challenge-platform/scripts/jsd/main.js';document.getElementsByTagName('head')[0].appendChild(a);";b.getElementsByTagName('head')[0].appendChild(d)}}if(document.body){var a=document.createElement('iframe');a.height=1;a.width=1;a.style.position='absolute';a.style.top=0;a.style.left=0;a.style.border='none';a.style.visibility='hidden';document.body.appendChild(a);if('loading'!==document.readyState)c();else if(window.addEventListener)document.addEventListener('DOMContentLoaded',c);else{var e=document.onreadystatechange||function(){};document.onreadystatechange=function(b){e(b);'loading'!==document.readyState&&(document.onreadystatechange=e,c())}}}})();</script></body>
</html>
