<div class="page-wrapper">
            <div class="content container-fluid">
                <div class="row">
                    <div class="col-xs-12">
                        <h4 class="page-title">Page List</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table custom-table m-b-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Page Title</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  <?php
                                  $i = 0;
                                  foreach ($pages as $page) {
                                    $i++;
                                    ?>
                                  <tr>
                                    <td><?php echo $i; ?></td>
                      							<td>
                      								<div class="service-desc">
                      									<h2><a href="<?php echo base_url().'language/'.$page['page_key']; ?>"><?php echo $page['page_title']; ?></a></h2>
                      								</div>
                                    </td>
                                  </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
