<div class="space-y-8">

    <!-- En-tête du catalogue -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm gap-4">
        <div>
            <h1 class="text-xl font-black text-slate-900 tracking-tight">📦 Catalogue des Articles</h1>
            <p class="text-xs text-slate-500 mt-1">Gérez le stock de vos produits, visualisez les visuels et suivez la disponibilité.</p>
        </div>
        <a href="<?= path('article', 'create') ?>" class="inline-flex items-center px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 text-white font-bold text-xs rounded-xl shadow-sm shadow-indigo-600/10 transition-all transform hover:-translate-y-0.5">
            <i class="fas fa-plus mr-2"></i>Nouvel Article
        </a>
    </div>

    <!-- Barre de Filtrage par Rayon Professionnelle -->
    <div class="flex flex-wrap items-center gap-2 bg-white p-4 rounded-xl border border-slate-200/80 shadow-sm">
        <span class="text-xs font-bold uppercase tracking-wider text-slate-400 mr-2"><i class="fas fa-filter mr-1"></i> Filtrer par categorie :</span>

        <!-- Bouton Tout afficher -->
        <a href="<?= path('article', 'index') ?>"
            class="px-3 py-1.5 text-xs font-semibold rounded-lg transition-all border <?= !isset($_GET['categorie_id']) ? 'bg-indigo-600 text-white border-indigo-600 shadow-sm' : 'bg-slate-50 text-slate-600 border-slate-200 hover:bg-slate-100' ?>">
            Tous les articles
        </a>

        <!-- Boucle dynamique sur vos catégories PostgreSQL -->
        <?php foreach ($categories as $cat): ?>
            <a href="<?= path('article', 'index', ['categorie_id' => $cat['id']]) ?>"
                class="px-3 py-1.5 text-xs font-semibold rounded-lg transition-all border <?= isset($_GET['categorie_id']) && $_GET['categorie_id'] == $cat['id'] ? 'bg-indigo-600 text-white border-indigo-600 shadow-sm' : 'bg-slate-50 text-slate-600 border-slate-200 hover:bg-slate-100' ?>">
                <?= htmlspecialchars($cat['nom']) ?>
            </a>
        <?php endforeach; ?>
    </div>

    <!-- Affichage sous forme de Grille  -->
    <?php if (empty($articles)): ?>
        <div class="bg-white rounded-2xl border border-slate-200 p-16 text-center shadow-sm">
            <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center mx-auto border border-slate-100 mb-4">
                <i class="fas fa-folder-open text-xl text-slate-400"></i>
            </div>
            <h3 class="text-sm font-bold text-slate-900">Aucun produit en stock</h3>
            <p class="text-xs text-slate-400 mt-1 max-w-xs mx-auto">Votre instance PostgreSQL ne contient aucun enregistrement pour le moment.</p>
        </div>
    <?php else: ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <?php foreach ($articles as $article): ?>
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden flex flex-col group hover:shadow-md hover:border-slate-300/80 transition-all duration-200 relative">

                    <!-- 1. En-tête de la carte : Catégorie & Bouton Supprimer -->
                    <div class="p-4 pb-0 flex items-center justify-between z-10">
                        <span class="inline-flex items-center px-2 py-0.5 bg-slate-50 text-slate-600 rounded-md text-xs font-bold border border-slate-100 uppercase tracking-wider">
                            <?= htmlspecialchars($article['categorie_nom']) ?>
                        </span>
    
                        <a href="<?= path('article', 'edit', ['id' => $article['id']]) ?>"
                            title="Modifier la référence"
                            class="w-7 h-7 bg-white text-slate-400 hover:text-blue-600 rounded-lg flex items-center justify-center transition-colors border border-slate-100 shadow-sm hover:border-blue-100 hover:bg-blue-50/50">
                            <i class="fas fa-pen text-xxs"></i>
                        </a>
                        <!-- Icône Corbeille Discrète -->
                        <a href="<?= path('article', 'delete', ['id' => $article['id']]) ?>"
                            onclick="return confirm('Supprimer définitivement cet article ?')"
                            title="Supprimer la référence"
                            class="w-7 h-7 bg-white text-slate-400 hover:text-rose-600 rounded-lg flex items-center justify-center transition-colors border border-slate-100 shadow-sm hover:border-rose-100 hover:bg-rose-50/50">
                            <i class="far fa-trash-alt text-xs"></i>
                        </a>
                    </div>

                    <!-- 2. Zone Image du produit -->
                    <div class="p-4 pt-3 flex justify-center">
                        <div class="w-full h-40 bg-slate-50 rounded-xl border border-slate-100 overflow-hidden flex items-center justify-center relative shadow-inner">
                            <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                src="<?= WEBROOT ?>upload/<?= htmlspecialchars($article['photo']) ?>"
                                alt="<?= htmlspecialchars($article['titre']) ?>"
                                onerror="this.onerror=null; this.src='<?= WEBROOT ?>upload/default.jpg';">

                            <!-- Badge Disponibilité  -->
                            <div class="absolute bottom-2 left-2">
                                <?php if ($article['statut'] === 'disponible'): ?>
                                    <span class="inline-flex items-center px-2 py-0.5 text-xxs font-bold rounded-md bg-white/90 backdrop-blur-xs text-emerald-800 border border-emerald-100 shadow-xs">
                                        <span class="w-1 h-1 mr-1.5 rounded-full bg-emerald-500"></span>Dispo
                                    </span>
                                <?php elseif ($article['statut'] === 'rupture'): ?>
                                    <span class="inline-flex items-center px-2 py-0.5 text-xxs font-bold rounded-md bg-white/90 backdrop-blur-xs text-rose-800 border border-rose-100 shadow-xs">
                                        <span class="w-1 h-1 mr-1.5 rounded-full bg-rose-500 animate-pulse"></span>Rupture
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center px-2 py-0.5 text-xxs font-bold rounded-md bg-white/90 backdrop-blur-xs text-slate-500 border border-slate-100 shadow-xs">
                                        <span class="w-1 h-1 mr-1.5 rounded-full bg-slate-400"></span>Archivé
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- 3. Corps de la carte : Titre & Description -->
                    <div class="px-4 pb-2 flex-1">
                        <h3 class="font-bold text-slate-900 text-sm tracking-tight truncate" title="<?= htmlspecialchars($article['titre']) ?>">
                            <?= htmlspecialchars($article['titre']) ?>
                        </h3>
                        <p class="text-xs text-slate-400 line-clamp-2 mt-1 h-8 leading-relaxed">
                            <?= htmlspecialchars($article['description']) ?: '<span class="italic text-slate-200">Aucune description...</span>' ?>
                        </p>
                    </div>

                    <!-- 4. Pied de la carte : Prix Unitaire -->
                    <div class="p-4 pt-3 bg-slate-50/50 border-t border-slate-100 flex items-center justify-between">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Prix de vente</span>
                        <span class="font-mono font-black text-slate-900 text-sm bg-white px-2.5 py-1 rounded-lg border border-slate-200/60 shadow-xs">
                            <?= number_format($article['prix'], 2, ',', ' ') ?> €
                        </span>
                    </div>

                </div>
            <?php endforeach; ?>
        </div>
        
            <!-- Barre de Pagination du Catalogue -->
    <?php if (isset($totalPages) && $totalPages > 1): ?>
        <div class="flex items-center justify-between bg-white px-6 py-4 rounded-2xl border border-slate-200/80 shadow-sm mt-6">
            <!-- Mobile -->
            <div class="flex flex-1 justify-between sm:hidden">
                <?php 
                $prevParams = ['page' => $currentPage - 1];
                if (isset($_GET['categorie_id'])) $prevParams['categorie_id'] = $_GET['categorie_id'];
                
                $nextParams = ['page' => $currentPage + 1];
                if (isset($_GET['categorie_id'])) $nextParams['categorie_id'] = $_GET['categorie_id'];
                ?>
                <a href="<?= path('article', 'index', $prevParams) ?>" class="<?= $currentPage <= 1 ? 'pointer-events-none opacity-40' : '' ?> relative inline-flex items-center rounded-xl border border-slate-200 bg-white px-4 py-2 text-xs font-bold text-slate-700 hover:bg-slate-50">
                    Précédent
                </a>
                <a href="<?= path('article', 'index', $nextParams) ?>" class="<?= $currentPage >= $totalPages ? 'pointer-events-none opacity-40' : '' ?> relative ml-3 inline-flex items-center rounded-xl border border-slate-200 bg-white px-4 py-2 text-xs font-bold text-slate-700 hover:bg-slate-50">
                    Suivant
                </a>
            </div>

            <!-- Bureau -->
            <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
                <div>
                    <p class="text-xs text-slate-500">
                        Page <span class="font-bold text-slate-900"><?= $currentPage ?></span> sur <span class="font-bold text-slate-900"><?= $totalPages ?></span>.
                    </p>
                </div>
                <div>
                    <nav class="isolate inline-flex -space-x-px rounded-xl bg-slate-50 p-1 border border-slate-200" aria-label="Pagination">
                        
                        <!-- Bouton Précédent -->
                        <a href="<?= path('article', 'index', $prevParams) ?>" class="<?= $currentPage <= 1 ? 'pointer-events-none text-slate-300' : 'text-slate-500 hover:bg-white hover:text-slate-700' ?> relative inline-flex items-center rounded-lg px-2.5 py-1.5 transition-all">
                            <i class="fas fa-chevron-left text-xxs"></i>
                        </a>

                        <!-- Numéros de pages -->
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <?php 
                            $pageParams = ['page' => $i];
                            if (isset($_GET['categorie_id'])) $pageParams['categorie_id'] = $_GET['categorie_id'];
                            ?>
                            <a href="<?= path('article', 'index', $pageParams) ?>" 
                               class="relative inline-flex items-center rounded-lg px-3 py-1.5 text-xs font-bold transition-all <?= $i === $currentPage ? 'bg-indigo-600 text-white shadow-sm' : 'text-slate-600 hover:bg-white hover:text-slate-900' ?>">
                                <?= $i ?>
                            </a>
                        <?php endfor; ?>

                        <!-- Bouton Suivant -->
                        <a href="<?= path('article', 'index', $nextParams) ?>" class="<?= $currentPage >= $totalPages ? 'pointer-events-none text-gray-300' : 'text-slate-500 hover:bg-white hover:text-slate-700' ?> relative inline-flex items-center rounded-lg px-2.5 py-1.5 transition-all">
                            <i class="fas fa-chevron-right text-xxs"></i>
                        </a>
                    </nav>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php endif; ?>
</div>