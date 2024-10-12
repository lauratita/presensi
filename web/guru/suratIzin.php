<?php include '../template/header.php' ?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h6 class="m-0 font-weight-bold text-primary"><span class="text-muted fw-flight">Konfirmasi Surat Izin</span></h6>

    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#navs-top-unVerified"
                type="button" role="tab" aria-controls="navs-top-unVerified" aria-selected="true">Unverified</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#nav-top-verified"
                type="button" role="tab" aria-controls="nav-top-verified" aria-selected="false">Verified</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#nav-top-disable"
                type="button" role="tab" aria-controls="nav-top-disable" aria-selected="false">Disable</button>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="navs-top-unVerified" role="tabpanel">
            <!-- DataTales Example -->
            <div class="card shadow mb-4 mt-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
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
</div>
<div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">...
</div>
<div class="tab-pane fade" id="contact-tab-pane" role="tabpanel" aria-labelledby="contact-tab" tabindex="0">...
</div>
<div class="tab-pane fade" id="disabled-tab-pane" role="tabpanel" aria-labelledby="disabled-tab" tabindex="0">
    ...</div>
</div>



</div>
<!-- /.container-fluid -->

<?php include '../template/footer.php' ?>