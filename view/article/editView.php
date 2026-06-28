<!-- view/article/editView.php -->
<div class="max-w-3xl bg-white rounded-2xl shadow-sm border border-gray-200 p-8 mx-auto my-6">
    
    <div class="flex items-center justify-between border-b border-gray-100 pb-6 mb-6">
        <div>
            <h2 class="text-xl font-bold text-gray-900 tracking-tight">
                <i class="fas fa-edit text-indigo-600 mr-2"></i>Modifier l'Article #<?= $article['id'] ?>
            </h2>
            <p class="text-sm text-gray-500 mt-1">Mettez à jour les informations de cette référence catalogue.</p>
        </div>
        <a href="<?= path('article', 'index') ?>" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-indigo-600 transition-colors bg-gray-50 hover:bg-gray-100 px-3 py-2 rounded-lg">
            <i class="fas fa-arrow-left mr-2 text-xs"></i> Annuler
        </a>
    </div>
    
    <?php if (!empty($errors)): ?>
        <div class="bg-rose-50 border-l-4 border-rose-500 text-rose-800 p-4 rounded-xl mb-6 shadow-sm">
            <ul class="list-disc list-inside text-xs font-medium space-y-0.5">
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    
    <form action="<?= path('article', 'update', ['id' => $article['id']]) ?>" method="POST" enctype="multipart/form-data" class="space-y-5" novalidate>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <div class="md:col-span-2">
                <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-2">Désignation du produit *</label>
                <input type="text" name="titre" required value="<?= htmlspecialchars($article['titre']) ?>" class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500/20 text-sm">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-2">Prix Unitaire (€) *</label>
                <input type="number" name="prix" step="0.01" min="0" required value="<?= $article['prix'] ?>" class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500/20 text-sm font-mono">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-2">Rayon / Catégorie *</label>
                <select name="categorie_id" required class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:outline-none bg-white text-sm">
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat['id'] ?>" <?= $cat['id'] == $article['categorie_id'] ? 'selected' : '' ?>><?= htmlspecialchars($cat['nom']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-2">Statut du stock</label>
                <select name="statut" class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:outline-none bg-white text-sm">
                    <option value="disponible" <?= $article['statut'] === 'disponible' ? 'selected' : '' ?>>🟢 En Stock</option>
                    <option value="rupture" <?= $article['statut'] === 'rupture' ? 'selected' : '' ?>>🔴 Rupture</option>
                    <option value="archive" <?= $article['statut'] === 'archive' ? 'selected' : '' ?>>⚫ Archivé</option>
                </select>
            </div>
        </div>

        <div>
            <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-2">Description</label>
            <textarea name="description" rows="3" class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm"><?= htmlspecialchars($article['description']) ?></textarea>
        </div>

        <!-- Section Photo Actuelle + Option Nouvel Upload -->
        <div class="p-4 bg-slate-50 border border-slate-200 rounded-xl space-y-3">
            <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider➡️">Visuel du produit</label>
            <div class="flex items-center space-x-4">
                <div class="w-16 h-16 rounded-lg overflow-hidden border border-slate-200 bg-white flex-shrink-0">
                    <img class="w-full h-full object-cover" src="<?= WEBROOT ?>upload/<?= $article['photo'] ?>" alt="Aperçu">
                </div>
                <div class="flex-1">
                    <input type="file" name="photo" accept="image/*" class="text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                    <p class="text-xxs text-gray-400 mt-1">Laissez vide si vous ne souhaitez pas modifier l'image actuelle.</p>
                </div>
            </div>
        </div>

        <div class="border-t border-gray-100 pt-5 mt-6 flex justify-end">
            <button type="submit" class="w-full md:w-auto px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm rounded-lg shadow-sm transition-all flex items-center justify-center">
                <i class="fas fa-sync mr-2 text-xs"></i> Enregistrer les modifications
            </button>
        </div>
    </form>
</div>
