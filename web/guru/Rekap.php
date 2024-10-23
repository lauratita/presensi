<?php include '../template/headerGuru.php' ?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h6 class="m-0 font-weight-bold text-primary"><span class="text-muted fw-flight">Rekap</span></h6>

    <!-- DataTales Example -->
    <div class="card shadow mb-4 mt-4">
        <div class="card-header">
            <div class="row g-3 align-items-center">
                <div class="col-auto">
                    <label for="" class="col-form-label" aria-label="Disabled input example" disabled
                        readonly>Filter Tanggal</label>
                </div>
                <div class="col-auto">
                    <input class="form-control" type="Date" value="12/10/2024" aria-label="Disabled input example">
                </div>
                <div class="col-auto">
                    <h3>-</h3>
                </div>
                <div class="col-auto">
                    <input class="form-control" type="Date" value="12/10/2024" aria-label="Disabled input example">
                </div>
                <div class="ml-auto mr-2 ">
                    <button type="button" data-toggle="modal" data-target="#eksportexcel"
                        class="btn btn-success">Eksport Excel</>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="eksportexcel" tabindex="-1" aria-labelledby="eksportexcelLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h3 class="modal-title fs-5" id="exampleModalLabel">Eksport Excel</h3>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <h6>Urutan : </h6>
                                <select class="form-select form-select-sm" aria-label="Small select example">
                                    <option selected="">Open this select menu</option>
                                    <option value="1">A-Z</option>
                                    <option value="2">Z-A</option>
                                </select>
                                <h6>Kehadiran : </h6>
                                <select class="form-select form-select-sm" aria-label="Small select example">
                                    <option selected="">Open this select menu</option>
                                    <option value="1">Semua</option>
                                    <option value="2">Hadir</option>
                                    <option value="3">Izin</option>
                                    <option value="4">Sakit</option>
                                </select>


                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-success">Eksport Excel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIS</th>
                            <th>Nama</th>
                            <th>Jam Masuk</th>
                            <th>Jam Keluar</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>PPLG1001</td>
                            <td>Hovivah</td>
                            <td>07:00</td>
                            <td>15:00</td>
                            <td>Selasa, 20 Oktober 2024</td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

<?php include '../template/footerGuru.php' ?>