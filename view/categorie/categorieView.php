<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="p-6 border-b border-slate-150 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-slate-50/50">
        <div>
            <h1 class="text-base font-bold text-slate-900 tracking-tight">📁 Répertoire des Catégories</h1>
            <p class="text-xs text-slate-500 mt-0.5">Configuration des rayons et arborescence de stockage.</p>
        </div>
        <a href="<?= path('categorie', 'create') ?>" class="inline-flex items-center px-3 py-2 bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 text-white font-semibold text-xs rounded-lg shadow-sm transition-colors">
            <i class="fas fa-plus mr-2 text-xxs"></i>Créer une catégorie
        </a>
    </div>


    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse table-auto">
            <thead>
                <tr class="bg-slate-50/70 border-b border-slate-200 text-xxs font-bold text-slate-500 uppercase tracking-wider select-none">
                    <th class="p-4 w-24 text-center">Code</th>
                    <th class="p-4 w-64">Libellé du rayon</th>
                    <th class="p-4">Description technique</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-xs text-slate-700">
                <?php if (empty($categories)): ?>
                    <tr>
                        <td colspan="3" class="p-12 text-center text-slate-400 font-medium bg-slate-50/20">
                            <i class="fas fa-inbox text-3xl mb-2.5 block text-slate-300"></i>
                            Aucune catégorie enregistrée dans le système.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($categories as $cat): ?>
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            
                            <!-- 1. Code Système unique -->
                            <td class="p-4 text-center font-mono font-semibold text-slate-400 select-all">
                                CAT-<?= str_pad($cat['id'], 3, '0', STR_PAD_LEFT) ?>
                            </td>
                            
                            <!-- 2. Nom principal -->
                            <td class="p-4 font-semibold text-slate-900">
                                <?= htmlspecialchars($cat['nom']) ?>
                            </td>
                            
                            <!-- 3. Description textuelle libre -->
                            <td class="p-4 text-slate-500 leading-relaxed max-w-xl truncate" title="<?= htmlspecialchars($cat['description']) ?>">
                                <?= htmlspecialchars($cat['description']) ?: '<span class="italic text-slate-300 font-normal">Aucune spécification rédigée</span>' ?>
                            </td>
                            
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Pied de tableau informatif -->
    <div class="p-4 bg-slate-50/30 border-t border-slate-100 text-xxs text-slate-400 font-medium flex items-center">
        <i class="fas fa-info-circle mr-1.5 text-slate-300"></i>
        <span>Total : <span class="font-bold text-slate-700"><?= count($categories) ?></span> rayon(s) configuré(s).</span>
    </div>
</div>
