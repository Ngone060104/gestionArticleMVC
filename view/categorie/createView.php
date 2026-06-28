<div class="max-w-2xl bg-white rounded-2xl shadow-sm border border-gray-200 p-8 mx-auto my-6">    
    <!-- En-tête -->
    <div class="flex items-center justify-between border-b border-gray-100 pb-6 mb-6">
        <div>
            <h2 class="text-xl font-bold text-gray-900 tracking-tight">
                <i class="fas fa-folder-plus text-blue-600 mr-2"></i>Nouveau Rayon / Catégorie
            </h2>
            <p class="text-sm text-gray-500 mt-1">Créez une nouvelle classification pour vos futurs articles.</p>
        </div>
        <a href="<?= path('categorie', 'index') ?>" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-blue-600 transition-colors bg-gray-50 hover:bg-gray-100 px-3 py-2 rounded-lg">
            <i class="fas fa-arrow-left mr-2 text-xs"></i> Retour à la liste
        </a>
    </div>
    
    <!-- Erreurs -->
    <?php if (!empty($errors)): ?>
        <div class="bg-rose-50 border-l-4 border-rose-500 text-rose-800 p-4 rounded-xl mb-6 shadow-sm" role="alert">
            <ul class="list-disc list-inside text-xs font-medium space-y-0.5">
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    
    <!-- Formulaire -->
    <form action="<?= path('categorie', 'store') ?>" method="POST" class="space-y-5" novalidate>
        
        <!-- Champ : Nom de la catégorie -->
        <div>
            <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-2">
                Nom de la catégorie <span class="text-rose-500">*</span>
            </label>
            <div class="relative rounded-lg shadow-sm">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                    <i class="fas fa-font text-xs"></i>
                </div>
                <input type="text" name="nom" required placeholder="Ex: Électroménager, Consommables..." 
                       class="w-full pl-9 pr-3 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 text-sm placeholder-gray-400">
            </div>
        </div>

        <!-- Champ : Description -->
        <div>
            <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-2">
                Description / Notes d'organisation
            </label>
            <textarea name="description" rows="4" placeholder="Décrivez le type d'articles que contiendra ce rayon..." 
                      class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 text-sm placeholder-gray-400"></textarea>
        </div>

        <!-- Bouton Soumission -->
        <div class="border-t border-gray-100 pt-5 mt-6 flex justify-end">
            <button type="submit" class="w-full md:w-auto px-6 py-3 bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white font-semibold text-sm rounded-lg shadow-sm transition-all transform hover:-translate-y-0.5 flex items-center justify-center">
                <i class="fas fa-save mr-2 text-xs"></i> Enregistrer la catégorie
            </button>
        </div>
    </form>
</div>
