<?php include '../template/headerGuru.php' ?>
<div class="container-fluid">

    <!-- Page Heading -->
    <h6 class="m-0 mt-4 mb-4 font-weight-bold text-primary"><span class="text-muted fw-flight">Konfirmasi Surat
            Izin</span></h6>

    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <button class="nav-link active" id="nav-unVerified-tab" data-toggle="tab" href="#tab-unVerified"
                data-bs-target="#nav-unVerified" type="button" role="tab" aria-controls="tab-unVerified"
                aria-selected="true">Unverified</button>
        </li>
        <li class="nav-item">
            <button class="nav-link" id="nav-verified-tab" data-toggle="tab" href="#tab-verified"
                data-bs-target="#nav-verified" type="button" role="tab" aria-controls="tab-verified"
                aria-selected="false">Verified</button>
        </li>
        <li class="nav-item">
            <button class="nav-link" id="nav-disable-tab" data-toggle="tab" href="#tab-disable"
                data-bs-target="#nav-disable" type="button" role="tab" aria-controls="tab-disable"
                aria-selected="false">Disable</button>
        </li>
    </ul>

    <!-- Tab Contents -->
    <div class="tab-content" id="myTabContent">

        <!-- Tab unVerified -->
        <div class="tab-pane fade show active" id="tab-unVerified" role="tabpanel" aria-labelledby="nav-unVerified-tab">
            <div class="card shadow mb-4 mt-4">
                <h5 class="card-header">UnVerified</h5>
                <div class="card-body">
                    <div class="table-responsive">
                        <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                            <table class="table table-bordered" id="dataTable-unVerified" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NIS</th>
                                        <th>Nama</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>15</td>
                                        <td>PPLG10011</td>
                                        <td>Hovivah</td>
                                        <td><span class="badge bg-label-warning me-1">Unverified</span></td>
                                        <td>
                                            <button type="button" data-toggle="modal" data-target="#verifiedizin"
                                                class="btn btn-sm btn-primary">Verified</button>
                                        </td>
                                    </tr>
                                    <!-- Modal -->
                                    <div class="modal fade" id="verifiedizin" tabindex="-1"
                                        aria-labelledby="verifiedizinLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h3 class="modal-title fs-5" id="exampleModalLabel">Edit User</h3>
                                                    <button class="close" type="button" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <h6>NIS : 1231021 </h6>
                                                    <h6>NAMA : </h6>
                                                    <h6>FOTO SURAT : </h6>
                                                    <img src="../../web/img/contoh_surat.jpg" class="img-fluid" width="300" height="300" />
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button type="button" class="btn btn-danger">Disable</button>
                                                    <button type="button" class="btn btn-primary">Verified</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- End Tab unVerified -->

        <!-- Tab Verified -->
        <div class="tab-pane fade" id="tab-verified" role="tabpanel" aria-labelledby="nav-verified-tab">
            <div class="card shadow mb-4 mt-4">
                <h5 class="card-header">Verified</h5>
                <div class="card-body">
                    <div class="table-responsive">
                        <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                            <table class="table table-bordered" id="dataTable-verified" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NIS</th>
                                        <th>Nama</th>
                                        <th>Keterangan</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>PPLG1001</td>
                                        <td>Hovivah</td>
                                        <td>Hadir</td>
                                        <td><span class="badge bg-label-warning me-1">Verified</span></td>
                                        <td>
                                            <button type="button" data-toggle="modal" data-target="#updateverified"
                                                class="btn btn-sm btn-warning ">Change Verified</button>
                                    </tr>
                                    <div class="modal fade" id="updateverified" tabindex="-1"
                                        aria-labelledby="verifiedizinLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h3 class="modal-title fs-5" id="exampleModalLabel">Edit Verified</h3>
                                                    <button class="close" type="button" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <h6>NIS : 1231021 </h6>
                                                    <h6>NAMA : </h6>
                                                    <h6>FOTO SURAT : </h6>
                                                    <img src="../../web/img/contoh_surat.jpg" class="img-fluid" width="300" height="300" />
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button type="button" class="btn btn-danger">Disable</button>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Tab unVerified -->

        <!-- Tab Disable -->
        <div class="tab-pane fade" id="tab-disable" role="tabpanel" aria-labelledby="nav-disable-tab">
            <div class="card shadow mb-4 mt-4">
                <h5 class="card-header">Disable</h5>
                <div class="card-body">
                    <div class="table-responsive">
                        <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                            <table class="table table-bordered" id="dataTable-disable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NIS</th>
                                        <th>Nama</th>
                                        <th>Keterangan</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>PPLG1001</td>
                                        <td>Hovivah</td>
                                        <td>Hadir</td>
                                        <td><span class="badge bg-label-warning me-1">Disable</span></td>
                                        <td>
                                            <button type="button" data-toggle="modal" data-target="#updatedisable"
                                                class="btn btn-sm btn-warning ">Change Disable</button>
                                    </tr>
                                    <div class="modal fade" id="updatedisable" tabindex="-1"
                                        aria-labelledby="verifiedizinLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h3 class="modal-title fs-5" id="exampleModalLabel">Edit Disable</h3>
                                                    <button class="close" type="button" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <h6>NIS : 1231021 </h6>
                                                    <h6>NAMA : </h6>
                                                    <h6>FOTO SURAT : </h6>
                                                    <img src="../../web/img/contoh_surat.jpg" class="img-fluid" width="300" height="300" />
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button type="button" class="btn btn-success">Verified</button>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Tab Disable -->
        </div>
    </div>
    <!-- End tab Verified -->
</div>

</div>

<!-- <?php include '../template/footerGuru.php' ?> -->