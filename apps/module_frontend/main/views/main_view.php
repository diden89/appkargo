<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package APPKARGO
 * @copyright Noobscript
 * @author Sikelopes
 * @version 1.0
 * @access Public
 * @link /rab_frontend/apps/module_frontend/main/views/main_view.php
 */
?>

<div class="row">
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
            <div class="inner">
                <h2><?php echo number_format($so_total['total']);?></h2>
                <p>Total Pesanan Bulan Ini</p>
            </div>
            <div class="icon">
                <i class="ion ion-bag"></i>
            </div>
            <a href="<?php echo base_url('transaksi/daftar_sales_order'); ?>" class="small-box-footer">Lihat Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
            <div class="inner">
               <!--  <h3>53<sup style="font-size: 20px">%</sup></h3> -->
               <h2>Rp. <?php echo number_format($pendapatan_total['total']);?></h2>

                <p>Penghasilan Bulan Ini</p>
            </div>
            <div class="icon">
                <i class="ion ion-stats-bars"></i>
            </div>
            <a href="<?php echo base_url('transaksi/daftar_pembayaran_sales_order'); ?>" class="small-box-footer">Lihat Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
            <div class="inner">
                <h2><?php echo number_format($kendaraan_total['total']);?></h2>

                <p>Total Kendaraan</p>
            </div>
            <div class="icon">
                <i class="ion ion-model-s"></i>
            </div>
            <a href="<?php echo base_url('master_data/vehicle'); ?>" class="small-box-footer">Lihat Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-danger">
            <div class="inner">
                <h2><?php echo number_format($rekanan_total['total']);?></h2>

                <p>Total Rekanan</p>
            </div>
            <div class="icon">
                <i class="ion ion-person-stalker"></i>
            </div>
            <a href="<?php echo base_url('master_data/daftar_rekanan');?>" class="small-box-footer">Lihat Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->          
</div>
        <!-- /.row -->

    <div class="row">
        <div class="col-lg-6">
          <div class="card">
              <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                  <h3 class="card-title">Grafik Penghasilan Jasa</h3>
                </div>
              </div>
              <div class="card-body">
                <div class="d-flex">
                  <p class="d-flex flex-column">
                    <span class="text-bold text-lg" id="total_pendapatan"></span>
                    <span>Total Penghasilan</span>
                  </p>
                 <!--  <p class="ml-auto d-flex flex-column text-right">
                    <span class="text-success">
                      <i class="fas fa-arrow-up"></i> 33.1%
                    </span>
                    <span class="text-muted">Since last month</span>
                  </p> -->
                </div>
                <!-- /.d-flex -->

                <div class="position-relative mb-4">
                  <canvas id="sales-chart" height="200"></canvas>
                </div>

                <div class="d-flex flex-row justify-content-end">
                  <span class="mr-2">
                    <i class="fas fa-square text-primary"></i> Pendapatan
                  </span>

                  <span>
                    <i class="fas fa-square text-gray"></i> Pengeluaran
                  </span>
                </div>
              </div>
            </div>
            <!-- /.card -->
          </div>        
        </div>
    </div>       
        
        <!-- /.row -->


