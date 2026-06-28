<!-- view/article/createView.php -->
<div class="max-w-3xl bg-white rounded-2xl shadow-sm border border-gray-200 p-8 mx-auto my-6">
    
    <!-- En-tête du Formulaire -->
    <div class="flex items-center justify-between border-b border-gray-100 pb-6 mb-6">
        <div>
            <h2 class="text-xl font-bold text-gray-900 tracking-tight">
                <i class="fas fa-box-open text-blue-600 mr-2"></i>Nouveau Produit / Article
            </h2>
            <p class="text-sm text-gray-500 mt-1">Enregistrez une nouvelle référence dans votre catalogue PostgreSQL.</p>
        </div>
        <a href="<?= path('article', 'index') ?>" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-blue-600 transition-colors bg-gray-50 hover:bg-gray-100 px-3 py-2 rounded-lg">
            <i class="fas fa-arrow-left mr-2 text-xs"></i> Retour au catalogue
        </a>
    </div>
    
    <!-- Zone d'affichage des erreurs de validation -->
    <?php if (!empty($errors)): ?>
        <div class="bg-rose-50 border-l-4 border-rose-500 text-rose-800 p-4 rounded-xl mb-6 shadow-sm" role="alert">
            <div class="flex items-center mb-1">
                <i class="fas fa-exclamation-circle text-rose-500 mr-2"></i>
                <span class="font-semibold text-sm">Veuillez corriger les anomalies suivantes :</span>
            </div>
            <ul class="list-disc list-inside text-xs pl-6 space-y-0.5 font-medium">
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    
    <!-- Formulaire (ATTENTION AU MULTIPART/FORM-DATA OBLIGATOIRE POUR L'UPLOAD) -->
    <form action="<?= path('article', 'store') ?>" method="POST" enctype="multipart/form-data" class="space-y-5" novalidate>
        
        <!-- Grille : Désignation & Prix -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <!-- Champ : Titre -->
            <div class="md:col-span-2">
                <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-2">
                    Désignation du produit <span class="text-rose-500">*</span>
                </label>
                <div class="relative rounded-lg shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                        <i class="fas fa-tag text-xs"></i>
                    </div>
                    <input type="text" name="titre" required placeholder="Ex: Écran Gamer 27'' Asus" 
                           class="w-full pl-9 pr-3 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 text-sm placeholder-gray-400">
                </div>
            </div>

            <!-- Champ : Prix -->
            <div>
                <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-2">
                    Prix Unitaire (fcfa) <span class="text-rose-500">*</span>
                </label>
                <div class="relative rounded-lg shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                        <i class="fas fa-euro-sign text-xs"></i>
                    </div>
                    <input type="number" name="prix" step="0.01" min="0" required placeholder="0.00" 
                           class="w-full pl-9 pr-3 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 text-sm placeholder-gray-400">
                </div>
            </div>
        </div>

        <!-- Grille : Catégorie & Statut -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <!-- Champ : Liste déroulante des catégories -->
            <div>
                <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-2">
                    Rayon / Catégorie <span class="text-rose-500">*</span>
                </label>
                <div class="relative rounded-lg shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                        <i class="fas fa-folder text-xs"></i>
                    </div>
                    <select name="categorie_id" required class="w-full pl-9 pr-3 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 text-sm text-gray-700 bg-white">
                        <option value="" disabled selected>-- Choisir un rayon --</option>
                        <!-- Boucle dynamique sur vos catégories PostgreSQL -->
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['nom']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <!-- Champ : Statut de stock -->
            <div>
                <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-2">
                    Statut initial du stock
                </label>
                <div class="relative rounded-lg shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                        <i class="fas fa-boxes-stacked text-xs"></i>
                    </div>
                    <select name="statut" class="w-full pl-9 pr-3 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 text-sm text-gray-700 bg-white">
                        <option value="disponible" selected>🟢 En Stock (Disponible)</option>
                        <option value="rupture">🔴 En Rupture de stock</option>
                        <option value="archive">⚫ Référence Archivée</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Champ : Description -->
        <div>
            <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-2">
                Fiche descriptive / Spécifications techniques
            </label>
            <textarea name="description" rows="3" placeholder="Saisissez les caractéristiques du produit..." 
                      class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 text-sm placeholder-gray-400"></textarea>
        </div>

        <!-- Champ : Upload Média / Photo -->
        <div>
            <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-2">
                Visuel du produit (Photo)
            </label>
            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-xl hover:border-blue-400 transition-colors bg-gray-50/50 cursor-pointer relative group">
                <div class="space-y-1 text-center">
                    <i class="fas fa-image text-gray-400 text-3xl mb-2 group-hover:text-blue-500 transition-colors"></i>
                    <div class="flex text-sm text-gray-600 justify-center">
                        <label for="file-upload" class="relative cursor-pointer bg-transparent rounded-md font-semibold text-blue-600 hover:text-blue-500 focus-within:outline-none">
                            <span>Téléverser un fichier</span>
                            <input id="file-upload" name="photo" type="file" accept="image/*" class="sr-only" onchange="updateFileName(this)">
                        </label>
                    </div>
                    <p class="text-xxs text-gray-400 font-medium">Formats acceptés : PNG, JPG, JPEG, WEBP jusqu'à 3 Mo</p>
                    <!-- Zone dynamique pour afficher le nom du fichier sélectionné -->
                    <p id="file-name" class="text-xs font-bold text-emerald-600 mt-2 italic"></p>
                </div>
            </div>
        </div>

        <!-- Boutons de Validation -->
        <div class="border-t border-gray-100 pt-5 mt-6 flex justify-end">
            <button type="submit" class="w-full md:w-auto px-6 py-3 bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white font-semibold text-sm rounded-lg shadow-sm transition-all transform hover:-translate-y-0.5 flex items-center justify-center">
                <i class="fas fa-save mr-2 text-xs"></i> Enregistrer la référence
            </button>
        </div>
    </form>
</div>

<!-- Petit Script JavaScript pour afficher le nom de la photo sélectionnée en direct -->
<script>
function updateFileName(input) {
    const fileNameDisplay = document.getElementById('file-name');
    if (input.files && input.files.length > 0) {
        fileNameDisplay.innerHTML = `<i class="fas fa-file-image mr-1"></i> Fichier sélectionné : ${input.files[0].name}`;
    } else {
        fileNameDisplay.textContent = "";
    }
}
</script>
