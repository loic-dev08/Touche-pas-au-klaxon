<?php

/** @var string $csrf */
?>

<h1 class="h4 mb-3">Créer une agence</h1>

/admin/agencies/create 
<input type="hidden" name="_csrf" value="<?= htmlspecialchars($csrf) ?>">
<div class="mb-3">
    <label class="form-label">Nom</label>
    <input class="form-control" name="name" required>
</div>
<div class="d-flex justify-content-end">
    /admin/agenciesAnnuler</a>
    <button class="btn btn-success" type="submit">Créer</button>
</div>
</form>



