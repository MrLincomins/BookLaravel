<?php require_once "layout/header.php";
use Illuminate\Support\Facades\Auth;
$user = Auth::user();
?>

<div class="container-fluid">
    <div class="row gx-5">
        <div class="col">
            <div class="card-style settings-card-1 mb-30">
                <div
                    class="title mb-30 d-flex justify-content-between align-items-center">
                    <h6>Профиль</h6>
                    <button class="border-0 bg-transparent">
                        <span class="mdi mdi-account"></span>
                    </button>
                </div>
                <div class="profile-info ">
                    <div class="d-flex align-items-center mb-30">
                        <div class="image">
                            <img src="/resources/images/149452.png" alt="" height="250" width="250"/>
                        </div>
                        <div class="profile-meta">
                            <h5 class="text-bold text-dark mb-10"><?php echo $user->name; ?></h5>
                        </div>
                    </div>
                    <div class="input-style-1">
                        <label>Класс: <big> <?php echo $user->class ?> </big></label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require_once "layout/footer.php"; ?>
