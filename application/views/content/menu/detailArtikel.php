        <!-- CONTENT -->
        <main>
            <div class="d-flex mb-3 back">
                <?php if ($uri4 == 'sunting' || $uri4 == 'update') : ?>
                    <a class="my-auto" href="<?= site_url('cms/account/' . $username . '/artikel/') ?><?= $id_artikel; ?>"><i class="fas fa-circle-chevron-left fa-xl mr-2"></i></a>
                <?php endif; ?>
                <?php if ($uri4 == 'buatArtikel' || $uri4 == 'save') : ?>
                    <a class="my-auto" href="<?= site_url('cms/account/' . $username . '/artikel') ?>"><i class="fas fa-circle-chevron-left fa-xl mr-2"></i></a>
                <?php endif; ?>
                <h2 class="my-auto"><?= $heading ?></h2>
            </div>
            <div class="container card pb-1">
                <?php if ($uri4 == 'sunting' || $uri4 == 'update') : ?>
                    <form class="row pt-3 pb-2" action="<?= site_url('cms/account/' . $username . '/update/artikel/') . $id_artikel ?>" method="post" enctype="multipart/form-data">
                    <?php endif; ?>
                    <?php if ($uri4 == 'buatArtikel' || $uri4 == 'save') : ?>
                        <form class="row pt-3 pb-2" action="<?= site_url('cms/account/' . $username . '/save/artikel') ?>" method="post" enctype="multipart/form-data">
                        <?php endif; ?>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="label" for="judul">Judul Artikel</label>
                                <input type="text" class="form-control" name="judul" id="judul" placeholder="Masukkan judul" value="<?php $uri4 == 'sunting' ? print $judul : '' ?><?php
                                                                                                                                                                                    $uri4 == 'update' ? print set_value('judul') : '';
                                                                                                                                                                                    ?><?php $uri4 == 'buatArtikel' || $uri4 == 'save' ? print set_value('judul') : '' ?>">
                                <?= form_error('judul', '<small class="text-danger">', '</small>') ?>
                            </div>
                            <label for="sampul">Sampul Artikel</label>
                            <div class="custom-file mb-2">
                                <input type="file" class="custom-file-input" name="sampul" id="sampul" accept=".png, .jpg, .jpeg">
                                <?= form_error('sampul', '<small class="text-danger">', '</small>') ?>
                                <label class="custom-file-label" for="sampul"> <?php $uri4  == 'sunting' && $sampul != "" ? print $sampul : "Pilih file..." ?><?php
                                                                                                                                                                $uri4 == 'update' ? print $oldname : '';
                                                                                                                                                                ?><?php $uri4 == 'buatArtikel' || $uri4 == 'save' ? print 'Pilih file...' : '' ?></label>
                                <script>
                                    $(document).ready(function() {
                                        bsCustomFileInput.init()
                                    })
                                </script>
                                <small class="text-danger mt-2"><?php if (isset($error)) {
                                                                    print $error;
                                                                } ?></small>
                            </div>
                            <div class="form-group mt-2">
                                <label class="label" for="tag">Tag</label>
                                <input type="text" class="form-control" name="tag" id="tag" placeholder="Masukkan tag" value="<?php $uri4 == 'sunting' ? print $tag : '' ?><?php
                                                                                                                                                                            $uri4 == 'update' ? print set_value('tag') : '';
                                                                                                                                                                            ?><?php $uri4 == 'buatArtikel' || $uri4 == 'save' ? print set_value('tag') : '' ?>">
                            </div>
                            <div class="form-group">
                                <label class="label" for="link">Link Youtube <span style="font-size: 10px;">(Opsional)</span></label>
                                <span class="d-flex">
                                    <input type="text" class="form-control" name="link" id="link" placeholder="Masukkan link" autocomplete="off" <?php if ($uri4 == 'sunting' && !empty($link)) : ?> value="https://www.youtube.com/watch?v=<?= $link ?>" <?php endif; ?> <?php if ($uri4 == 'buatArtikel' || $uri4 == 'save') : ?> value="<?= set_value('link') ?>" <?php endif; ?>>
                                    <input type="hidden" id="link_video" name="link_video" value="<?php $uri4 == 'sunting' ? print $link : '' ?><?php
                                                                                                                                                $uri4 == 'update' ? print set_value('link') : '';
                                                                                                                                                ?><?php $uri4 == 'buatArtikel' || $uri4 == 'save' ? print set_value('link') : '' ?>">
                                    <button type="button" class="btn btn-primary" onclick="showVideo()" data-toggle="modal" data-target="#pratinjau" id="link">
                                        Tinjau
                                    </button>
                                </span>
                                <small class="text-danger"> *Pastikan video dengan klik tombol tinjau</small>
                                <!-- Modal -->
                                <div class="modal fade" id="pratinjau" tabindex="-1" aria-labelledby="pratinjauLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="pratinjauLabel">Pratinjau</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="embed-responsive embed-responsive-16by9 d-none" id="vid">
                                                    <iframe class="embed-responsive-item" id="cekyt"></iframe>
                                                </div>
                                                <div class="d-block mt-3" id="warn">
                                                    <p class="text-center">Video Tidak Ditemukan</p>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="label" for="artikel">Artikel</label>
                                <textarea id="artikel" name="artikel" required></textarea>
                                <?= form_error('artikel', '<small class="text-danger">', '</small>') ?>
                                <script>
                                    $('#artikel').summernote({
                                        placeholder: 'Tulis artikel disini',
                                        tabsize: 2,
                                        height: 252.5,
                                        toolbar: [
                                            ['style', ['bold', 'italic', 'underline', 'clear']],
                                            ['para', ['ul', 'ol', 'paragraph']],
                                            ['fontsize', ['fontsize']],
                                            ['height', ['height']],
                                            ['insert', ['link', 'picture']],
                                            ['view', ['fullscreen']]
                                        ],
                                        callbacks: {
                                            onImageUpload: function(image) {
                                                uploadImage(image[0]);
                                            },
                                            onMediaDelete: function(target) {
                                                deleteImage(target[0].src);
                                            }
                                        },
                                        disableDragAndDrop: true,
                                        codeviewFilter: false,
                                        codeviewIframeFilter: true,
                                    })

                                    <?php if ($uri4 == 'sunting') : ?>
                                        $('#artikel').summernote('code', `<?= $artikel; ?>`);
                                    <?php endif; ?>
                                    <?php if ($uri4 == 'save' || $uri4 == 'update') : ?>
                                        $('#artikel').summernote('code', ` <?= set_value('artikel') ?>`);
                                    <?php endif; ?>
                                    $('#artikel').summernote('formatPara');
                                    if ($('#artikel').summernote('isEmpty')) {
                                        $('#summernote').summernote('reset');
                                        $('#artikel').summernote('code', ` <?= form_error('artikel') ?>`);
                                    }

                                    function uploadImage(image) {
                                        var data = new FormData();
                                        data.append("image", image);
                                        $.ajax({
                                            url: "<?= site_url('cms/summernoteUploadImage') ?>",
                                            cache: false,
                                            contentType: false,
                                            processData: false,
                                            data: data,
                                            type: "POST",
                                            success: function(url) {
                                                $('#artikel').summernote("insertImage", url);
                                            },
                                            error: function(data) {
                                                console.log(data);
                                            }
                                        });
                                    }

                                    function deleteImage(src) {
                                        $.ajax({
                                            data: {
                                                src: src
                                            },
                                            type: "POST",
                                            url: "<?= site_url('cms/summernoteDeleteImage') ?>",
                                            cache: false,
                                            success: function(response) {
                                                console.log(response);
                                            }
                                        });
                                    }
                                    $('.note-statusbar').hide();
                                </script>
                            </div>
                        </div>
                        <div class="form-group col-12 d-flex justify-content-center mt-n1 mb-2">
                            <?php if ($uri4 == 'sunting' || $uri4 == 'update') : ?>
                                <button type="submit" class="btn btn-warning">Sunting</button>
                            <?php endif; ?>
                            <?php if ($uri4 == 'buatArtikel' || $uri4 == 'save') : ?>
                                <button type="submit" class="btn btn-success">Buat</button>
                            <?php endif; ?>
                        </div>
                        </form>
            </div>
        </main>
        </div>