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
                    <label for="" class="col-form-label" aria-label="Disabled input example" disabled readonly>Filter
                        Tanggal</label>
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
                    <button type="button" class="btn btn-success">Eksport Excel</>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTablerekap" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIS</th>
                            <th>Nama</th>
                            <th>Keterangan</th>
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
                            <th>Sakit </th>
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