<?php
/** @var array $agency */
/** @var string $csrf */
?>

<h1 class="h4 mb-3">Modifier une agence</h1>

<form action="/admin/agencies/edit/<?= (int)$agency['id'] ?>" method="post" class="card p-3 shadow-sm">

    <input type="hidden" name="_csrf" value="<?= htmlspecialchars($csrf) ?>">

    <div class="mb-3">
        <label class="form-label">Nom</label>
        <input 
            class="form-control" 
            name="name" 
            value="<?= htmlspecialchars($agency['name']) ?>" 
            required
        >
    </div>

    <div class="d-flex justify-content-end">
        <a href="/admin/agencies" class="btn btn-secondary me-2">Annuler</a>
        <button class="btn btn-warning" type="submit">Enregistrer</button>
    </div>

</form>
