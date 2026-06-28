<!DOCTYPE html>
<html lang="fr" class="h-full bg-gray-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Catalog | Gestion des Stocks' ?></title>
   <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body class="h-full flex overflow-hidden font-sans antialiased text-gray-900">

    <?php
    // Détection du contrôleur actuel dans l'URL pour appliquer la classe "actif" sur le bon onglet
    $currentCtrl = $_GET['controller'] ?? 'article';
    ?>
    <!-- 1. SIDEBAR POUR LES ÉCRANS MOBILES        -->

    <div id="sidebar-mobile" class="hidden fixed inset-0 z-50 md:hidden" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-slate-900/80 transition-opacity" onclick="toggleSidebar()"></div>
        <div class="fixed inset-y-0 left-0 flex w-full max-w-xs bg-slate-900">
            <div class="absolute top-0 right-0 -mr-12 pt-4">
                <button type="button" onclick="toggleSidebar()" class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none text-white">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>
            <div class="flex flex-col flex-1 h-full bg-slate-900 border-r border-slate-800">
                <div class="flex items-center h-16 flex-shrink-0 px-6 bg-slate-950/40 border-b border-slate-800/60">
                    <div class="flex items-center space-x-3">
                        <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-blue-600">
                            <i class="fas fa-boxes-stacked text-white text-sm"></i>
                        </div>
                        <span class="text-sm font-bold text-white uppercase tracking-wider">StockManager</span>
                    </div>
                </div>
                <div class="flex flex-col flex-1 overflow-y-auto">
                    <nav class="flex-1 px-4 py-6 space-y-1.5">
                        <span class="px-3 text-xxs font-semibold text-slate-500 uppercase tracking-widest block mb-2">Navigation</span>
                        
                        <!-- Onglet Articles Mobile -->
                        <a href="<?= path('article', 'index') ?>" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-xl <?= $currentCtrl === 'article' ? 'bg-blue-600 text-white' : 'text-slate-400 hover:bg-slate-800/60 hover:text-slate-200' ?>">
                            <i class="fas fa-tags text-base w-5 mr-3"></i>Gestion Articles
                        </a>
                        
                        <!-- Onglet Catégories Mobile -->
                        <a href="<?= path('categorie', 'index') ?>" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-xl <?= $currentCtrl === 'categorie' ? 'bg-blue-600 text-white' : 'text-slate-400 hover:bg-slate-800/60 hover:text-slate-200' ?>">
                            <i class="fas fa-layer-group text-base w-5 mr-3"></i>Catégories
                        </a>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. SIDEBAR POUR LES ÉCRANS DE BUREAU      -->
    <div class="hidden md:flex md:flex-shrink-0">
        <div class="flex flex-col w-64 border-r border-gray-200 bg-slate-900">
            
            <!-- Logo de l'application -->
            <div class="flex items-center h-16 flex-shrink-0 px-6 bg-slate-950/40 border-b border-slate-800/60">
                <div class="flex items-center space-x-3">
                    <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-blue-600 shadow-sm shadow-blue-500/30">
                        <i class="fas fa-boxes-stacked text-white text-sm"></i>
                    </div>
                    <span class="text-sm font-bold text-white uppercase tracking-wider">StockManager <span class="text-blue-500 font-mono text-xs lowercase">v2</span></span>
                </div>
            </div>

            <!-- Liens de Navigation principale -->
            <div class="flex flex-col flex-1 overflow-y-auto">
                <nav class="flex-1 px-4 py-6 space-y-1.5">

                    <!-- Onglet : Gestion Articles -->
                    <a href="<?= path('article', 'index') ?>" class="flex items-center justify-between px-3 py-2.5 text-sm font-medium rounded-xl transition-all group <?= $currentCtrl === 'article' ? 'bg-blue-600 text-white shadow-sm shadow-blue-600/10' : 'text-slate-400 hover:bg-slate-800/60 hover:text-slate-200' ?>">
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-tags text-base w-5 opacity-90"></i>
                            <span>Gestion Articles</span>
                        </div>
                        <i class="fas fa-chevron-right text-xxs opacity-0 group-hover:opacity-40 transition-opacity"></i>
                    </a>

                    <!-- Onglet : Catégories -->
                    <a href="<?= path('categorie', 'index') ?>" class="flex items-center justify-between px-3 py-2.5 text-sm font-medium rounded-xl transition-all group <?= $currentCtrl === 'categorie' ? 'bg-blue-600 text-white shadow-sm shadow-blue-600/10' : 'text-slate-400 hover:bg-slate-800/60 hover:text-slate-200' ?>">
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-layer-group text-base w-5 opacity-90"></i>
                            <span>Catégories</span>
                        </div>
                        <i class="fas fa-chevron-right text-xxs opacity-0 group-hover:opacity-40 transition-opacity"></i>
                    </a>

                </nav>
            </div>

            <!-- Infos Profil -->
            <div class="flex-shrink-0 flex border-t border-slate-800/80 p-4 bg-slate-950/20">
                <div class="flex items-center space-x-3 w-full">
                    <img class="inline-block h-9 w-9 rounded-xl border border-slate-700 object-cover shadow-sm" 
                         src="https://ui-avatars.com" alt="Avatar">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-slate-200 truncate">Gestionnaire Stock</p>

                    </div>
                </div>
            </div>
            
        </div>
    </div>

    <!-- 3. CONTENU PRINCIPAL DE L'APPLICATION      -->
    <div class="flex flex-col flex-1 overflow-hidden min-w-0 bg-gray-50/50">

        <!-- Top Header blanc -->
        <header class="flex items-center justify-between flex-shrink-0 h-16 px-8 bg-white border-b border-gray-200/80 shadow-sm">
            <div class="flex items-center space-x-4">
                <button onclick="toggleSidebar()" class="text-gray-400 hover:text-gray-600 focus:outline-none md:hidden transition-colors">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                <div class="flex items-center space-x-2 text-xs font-medium text-gray-400">
                    <span>Espace Catalogue</span>
                    <i class="fas fa-chevron-right text-xxs opacity-60"></i>
                    <span class="text-gray-700 font-semibold"><?= $currentCtrl === 'article' ? 'Articles' : 'Catégories' ?></span>
                </div>
            </div>

            <div class="flex items-center space-x-4">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-50 text-indigo-700 border border-indigo-200">
                    <span class="w-1 h-1 mr-1.5 rounded-full bg-indigo-500 animate-pulse"></span>PostgreSQL 15 Active
                </span>
            </div>
        </header>

        <!-- Zone de rendu des vues -->
        <main class="flex-1 overflow-y-auto p-8">
            <div class="max-w-7xl mx-auto">
                <?= $content ?>
            </div>
        </main>
        
    </div>

    <!-- Script Menu Mobile toggle -->
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar-mobile');
            sidebar.classList.toggle('hidden');
        }
    </script>
</body>
</html>
