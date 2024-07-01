        <!-- CONTENT -->
        <main>
            <h2>Tema</h2>
            <div class="card p-4">
                <form action="<?= site_url("cms/account/" . $username . '/terapkanTema') ?>" method="post">
                    <select class="custom-select mb-1" id="tema" name="tema">
                        <option value="<?= $tema ?>" selected hidden><?= $tema ?></option>
                        <option value="Ungu">Ungu</option>
                        <option value="Biru">Biru</option>
                        <option value="Hijau">Hijau</option>
                        <option value="Merah">Merah</option>
                    </select>
                    <div class="d-flex align-items-center justify-content-center">
                        <button type="submit" class="btn btn-success d-block mt-3 mr-1">Terapkan</button>
                        <a href="<?= base_url() ?>" class="btn btn-warning mt-3 ml-1"><i class="fas fa-globe mr-2"></i>Lihat Web</a>
                    </div>
                </form>
            </div>
        </main>
        </div>