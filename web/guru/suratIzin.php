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
                                        <td>1</td>
                                        <td>PPLG1001</td>
                                        <td>Laura Tita A.G</td>
                                        <td><span class="badge bg-label-warning me-1">Unverified</span></td>
                                        <td>
                                            <form action="" id=""><button type="button" class="btn btn-sm btn-primary"
                                                    onclick="">Verified</button></form>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>PPLG1002</td>
                                        <td>Melvina Citra Saqina</td>
                                        <td><span class="badge bg-label-warning me-1">Unverified</span></td>
                                        <td>
                                            <form action="" id=""><button type="button" class="btn btn-sm btn-primary"
                                                    onclick="">Verified</button></form>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>PPLG1003</td>
                                        <td>Hovivah</td>
                                        <td><span class="badge bg-label-warning me-1">Unverified</span></td>
                                        <td>
                                            <form action="" id=""><button type="button" class="btn btn-sm btn-primary"
                                                    onclick="">Verified</button></form>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td>PPLG1005</td>
                                        <td>Laura Tita A.G</td>
                                        <td><span class="badge bg-label-warning me-1">Unverified</span></td>
                                        <td>
                                            <form action="" id=""><button type="button" class="btn btn-sm btn-primary"
                                                    onclick="">Verified</button></form>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>5</td>
                                        <td>PPLG1006</td>
                                        <td>Dwi Farhan</td>
                                        <td><span class="badge bg-label-warning me-1">Unverified</span></td>
                                        <td>
                                            <form action="" id=""><button type="button" class="btn btn-sm btn-primary"
                                                    onclick="">Verified</button></form>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>6</td>
                                        <td>PPLG1007</td>
                                        <td>M. Dien Vito</td>
                                        <td><span class="badge bg-label-warning me-1">Unverified</span></td>
                                        <td>
                                            <form action="" id=""><button type="button" class="btn btn-sm btn-primary"
                                                    onclick="">Verified</button></form>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>7</td>
                                        <td>PPLG1008</td>
                                        <td>Laura Tita A.G</td>
                                        <td><span class="badge bg-label-warning me-1">Unverified</span></td>
                                        <td>
                                            <form action="" id=""><button type="button" class="btn btn-sm btn-primary"
                                                    onclick="">Verified</button></form>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>8</td>
                                        <td>PPLG1009</td>
                                        <td>Laura Tita A.G</td>
                                        <td><span class="badge bg-label-warning me-1">Unverified</span></td>
                                        <td>
                                            <form action="" id=""><button type="button" class="btn btn-sm btn-primary"
                                                    onclick="">Verified</button></form>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>9</td>
                                        <td>PPLG10010</td>
                                        <td>Laura Tita A.G</td>
                                        <td><span class="badge bg-label-warning me-1">Unverified</span></td>
                                        <td>
                                            <form action="" id=""><button type="button" class="btn btn-sm btn-primary"
                                                    onclick="">Verified</button></form>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>10</td>
                                        <td>PPLG1004</td>
                                        <td>Laura Tita A.G</td>
                                        <td><span class="badge bg-label-warning me-1">Unverified</span></td>
                                        <td>
                                            <form action="" id=""><button type="button" class="btn btn-sm btn-primary"
                                                    onclick="">Verified</button></form>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>11</td>
                                        <td>PPLG1009</td>
                                        <td>Laura Tita A.G</td>
                                        <td><span class="badge bg-label-warning me-1">Unverified</span></td>
                                        <td>
                                            <form action="" id=""><button type="button" class="btn btn-sm btn-primary"
                                                    onclick="">Verified</button></form>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>12</td>
                                        <td>PPLG10011</td>
                                        <td>Laura Tita A.G</td>
                                        <td><span class="badge bg-label-warning me-1">Unverified</span></td>
                                        <td>
                                            <form action="" id=""><button type="button" class="btn btn-sm btn-primary"
                                                    onclick="">Verified</button></form>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>13</td>
                                        <td>PPLG10015</td>
                                        <td>Laura Tita A.G</td>
                                        <td><span class="badge bg-label-warning me-1">Unverified</span></td>
                                        <td>
                                            <form action="" id=""><button type="button" class="btn btn-sm btn-primary"
                                                    onclick="">Verified</button></form>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>14</td>
                                        <td>PPLG10012</td>
                                        <td>Ita Nurlaili</td>
                                        <td><span class="badge bg-label-warning me-1">Unverified</span></td>
                                        <td>
                                            <form action="" id=""><button type="button" class="btn btn-sm btn-primary"
                                                    onclick="">Verified</button></form>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>15</td>
                                        <td>PPLG10011</td>
                                        <td>Laura Tita A.G</td>
                                        <td><span class="badge bg-label-warning me-1">Unverified</span></td>
                                        <td>
                                            <form action="" id=""><button type="button" class="btn btn-sm btn-primary"
                                                    onclick="">Verified</button></form>
                                        </td>
                                    </tr>
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
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>PPLG1001</td>
                                        <td>Laura Tita A.G</td>
                                        <td>Hadir</td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>PPLG1002</td>
                                        <td>Melvina Citra Saqina</td>
                                        <td>Sakit</td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>PPLG1003</td>
                                        <td>Hovivah</td>
                                        <td>Hadir</td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td>PPLG1005</td>
                                        <td>Laura Tita A.G</td>
                                        <td>Hadir</td>
                                    </tr>
                                    <tr>
                                        <td>5</td>
                                        <td>PPLG1006</td>
                                        <td>Dwi Farhan</td>
                                        <td>Hadir</td>
                                    </tr>
                                    <tr>
                                        <td>6</td>
                                        <td>PPLG1007</td>
                                        <td>M. Dien Vito</td>
                                        <td>Hadir</td>
                                    </tr>
                                    <tr>
                                        <td>7</td>
                                        <td>PPLG1008</td>
                                        <td>Laura Tita A.G</td>
                                        <td>Izin</td>
                                    </tr>
                                    <tr>
                                        <td>8</td>
                                        <td>PPLG1009</td>
                                        <td>Laura Tita A.G</td>
                                        <td>Hadir</td>
                                    </tr>
                                    <tr>
                                        <td>9</td>
                                        <td>PPLG10010</td>
                                        <td>Laura Tita A.G</td>
                                        <td>Hadir</td>
                                    </tr>
                                    <tr>
                                        <td>10</td>
                                        <td>PPLG1004</td>
                                        <td>Laura Tita A.G</td>
                                        <td>Hadir</td>
                                    </tr>
                                    <tr>
                                        <td>11</td>
                                        <td>PPLG1009</td>
                                        <td>Laura Tita A.G</td>
                                        <td>Hadir</td>
                                    </tr>
                                    <tr>
                                        <td>12</td>
                                        <td>PPLG10011</td>
                                        <td>Laura Tita A.G</td>
                                        <td>Hadir</td>
                                    </tr>
                                    <tr>
                                        <td>13</td>
                                        <td>PPLG10015</td>
                                        <td>Laura Tita A.G</td>
                                        <td>Hadir</td>
                                    </tr>
                                    <tr>
                                        <td>14</td>
                                        <td>PPLG10012</td>
                                        <td>Ita Nurlaili</td>
                                        <td>Hadir</td>
                                    </tr>
                                    <tr>
                                        <td>15</td>
                                        <td>PPLG10011</td>
                                        <td>Laura Tita A.G</td>
                                        <td>Alpha</td>
                                    </tr>
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
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>PPLG1001</td>
                                        <td>Laura Tita A.G</td>
                                        <td>Hadir</td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>PPLG1002</td>
                                        <td>Melvina Citra Saqina</td>
                                        <td>Sakit</td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>PPLG1003</td>
                                        <td>Hovivah</td>
                                        <td>Hadir</td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td>PPLG1005</td>
                                        <td>Laura Tita A.G</td>
                                        <td>Hadir</td>
                                    </tr>
                                    <tr>
                                        <td>5</td>
                                        <td>PPLG1006</td>
                                        <td>Dwi Farhan</td>
                                        <td>Hadir</td>
                                    </tr>
                                    <tr>
                                        <td>6</td>
                                        <td>PPLG1007</td>
                                        <td>M. Dien Vito</td>
                                        <td>Hadir</td>
                                    </tr>
                                    <tr>
                                        <td>7</td>
                                        <td>PPLG1008</td>
                                        <td>Laura Tita A.G</td>
                                        <td>Izin</td>
                                    </tr>
                                    <tr>
                                        <td>8</td>
                                        <td>PPLG1009</td>
                                        <td>Laura Tita A.G</td>
                                        <td>Hadir</td>
                                    </tr>
                                    <tr>
                                        <td>9</td>
                                        <td>PPLG10010</td>
                                        <td>Laura Tita A.G</td>
                                        <td>Hadir</td>
                                    </tr>
                                    <tr>
                                        <td>10</td>
                                        <td>PPLG1004</td>
                                        <td>Laura Tita A.G</td>
                                        <td>Hadir</td>
                                    </tr>
                                    <tr>
                                        <td>11</td>
                                        <td>PPLG1009</td>
                                        <td>Laura Tita A.G</td>
                                        <td>Hadir</td>
                                    </tr>
                                    <tr>
                                        <td>12</td>
                                        <td>PPLG10011</td>
                                        <td>Laura Tita A.G</td>
                                        <td>Hadir</td>
                                    </tr>
                                    <tr>
                                        <td>13</td>
                                        <td>PPLG10015</td>
                                        <td>Laura Tita A.G</td>
                                        <td>Hadir</td>
                                    </tr>
                                    <tr>
                                        <td>14</td>
                                        <td>PPLG10012</td>
                                        <td>Ita Nurlaili</td>
                                        <td>Hadir</td>
                                    </tr>
                                    <tr>
                                        <td>15</td>
                                        <td>PPLG10011</td>
                                        <td>Laura Tita A.G</td>
                                        <td>Alpha</td>
                                    </tr>
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