<main class="mt-lg-n3 mt-xl-n2" style="overflow-y: auto;">
    <!-- FORM KONTAK -->
    <section class="contact_height justify-content-center">
        <div class="container pt-4 pb-5 py-md-2 mt-0 mt-md-1 mt-lg-n2 mb-5 my-lg-0">
            <h2 class="text-center pb-1"><i class="far fa-envelope mr-2"></i>Hubungi Kami</h2>
            <div class="card border-rad contact_form mt-3">
                <div class="row">
                    <div class="col-md-6 fs_14">
                        <div class="px-4 pt-3 pt-lg-3 pb-lg-1 pl-lg-4 ml-lg-1 pr-lg-0">
                            <form action="<?= site_url('home/form') ?>" method="post" target="_blank" class="pt-1">
                                <div class="row">
                                    <div class="form-group col-6">
                                        <label class="label" for="name">Nama Lengkap</label>
                                        <input type="text" class="form-control" style="font-size: 14px;" name="name" id="name" placeholder="Nama">
                                    </div>
                                    <div class="form-group col-6">
                                        <label class="label" for="email">Alamat Email</label>
                                        <input type="email" class="form-control" style="font-size: 14px;" name="email" id="email" placeholder="Email">
                                    </div>
                                </div>
                                <div class="form-group mt-n1">
                                    <label class="label" for="subject">Subjek</label>
                                    <input type="text" class="form-control" style="font-size: 14px;" name="subject" id="subject" placeholder="Subjek">
                                </div>
                                <div class="form-group mt-n1">
                                    <label class="label" for="message">Pesan</label>
                                    <textarea name="message" class="form-control" style="font-size: 14px;" id="message" cols="30" rows="3" placeholder="Pesan"></textarea>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-block d-block mx-auto">Kirim Pesan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-6 ratio ratio-1x1">
                        <iframe style="border:3px solid #8f8f89" width="100%" height="100%" id="gmap_canvas" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d247.47267843339094!2d110.40789347118483!3d-7.06053833696647!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7089425c802481%3A0x745e54e4b1f6f7b1!2sPAUD%20RUSA%20DAN%20BIMBEL%20BANYUMANIK%20SEMARANG!5e0!3m2!1sen!2sid!4v1679619751802!5m2!1sen!2sid" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php if ($this->session->flashdata('toast')) : ?>
        <div class="position-fixed bottom-0 right-0 p-3" style="z-index: 5; right: 1em; bottom: 0;">
            <div id="liveToast" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true" data-delay="2000">
                <div class="toast-body text-light">
                    <?= $this->session->flashdata('toast'); ?>
                </div>
            </div>
            <script>
                $('.toast').toast('show');
            </script>
        <?php endif; ?>
</main>