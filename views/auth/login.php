<?php
/** @var string $csrf */
?>

<div class="row justify-content-center">
    <div class="col-5">
        <div class="card shadow-sm">
            <div class="card-header bg-secondary-app text-white fw-bold">Connexion</div>
            <div class="card-body">
                /login 
                <input type="hidden" name="_csrf" value="<?= htmlspecialchars($csrf) ?>">

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input name="email" type="email"class="form-control"require autofocus>
                </div>

                <div class="mb-3">
                    <label class="form-label">Mot de passe</label>
                    <input name="password" type="password" class="form-control" required>
                </div>

                <button class="btn btn- primary-app w-100" type="submit">Se connecter</button>
            </form>
            </div>
        </div>
    </div>
</div>
