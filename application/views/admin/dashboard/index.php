        <div class="page-wrapper">
            <div class="content container-fluid">
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-lg-3">
                        <div class="dash-widget">
                            <span class="dash-widget-icon"><i class="far fa-newspaper"></i></span>
                            <div class="dash-widget-info">
                                <h3><?php
                                if(empty($requests))
                                {
                                  $requests =0;
                                }
                                echo $requests; ?></h3>
                                <span>Requests</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-lg-3">
                        <div class="dash-widget dash-widget5">
                            <span class="dash-widget-icon bg-success"><i class="far fa-user"></i></span>
                            <div class="dash-widget-info">
                                <h3><?php
                                if(empty($providers))
                                {
                                  $providers =0;
                                }
                                echo $providers; ?></h3>
                                <span>Providers</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-lg-3">
                        <div class="dash-widget dash-widget5">
                            <span class="dash-widget-icon bg-warning"><i class="far fa-money-bill-alt"></i></span>
                            <div class="dash-widget-info">
                                <h3><sup><?php echo $currency_symbol; ?></sup><?php echo $revenue; ?></h3>
                                <span>Revenue</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-lg-3">
                        <div class="dash-widget dash-widget5">
                            <span class="dash-widget-icon bg-danger"><i class="far fa-hourglass"></i></span>
                            <div class="dash-widget-info">
                                <h3><?php
                                if(empty($pending))
                                {
                                  $pending =0;
                                } echo $pending; ?></h3>
                                <span>Pending</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card-box">
                            <div id="provide-request-bar-graph"></div>
                        </div>
                    </div>
                </div>
             
            </div>
        </div>
