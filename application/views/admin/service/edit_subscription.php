 <div class="page-wrapper">
            <div class="content container-fluid">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <h4 class="page-title">Edit Subscription</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <form id="editSubscription" method="post">
                            <div class="form-group">
                                <label>Subscription Name</label>
                                <input class="form-control" type="text" value="<?php echo $subscription['subscription_name']; ?>" name="subscription_name" id="subscription_name">
                                <input class="form-control" type="hidden" value="<?php echo $subscription['id']; ?>" name="subscription_id" id="subscription_id">
                            </div>
                            <div class="form-group">
                                <label>Subscription Amount</label>
                                <input class="form-control" type="number" step="0.01" min="0" value="<?php echo $subscription['fee']; ?>" name="amount" id="amount">
                            </div>
                            <div class="form-group">
                                <label>Subscription Duration</label>
                                <select class="form-control" name="duration" id="duration">
                                  <option value="">Select Duration</option>
                                  <option value="1" <?php echo $subscription['duration']==1 ? "selected":""; ?>>Per Month</option>
                                  <option value="3" <?php echo $subscription['duration']==3 ? "selected":""; ?>>Per 3 Months</option>
                                  <option value="6" <?php echo $subscription['duration']==6 ? "selected":""; ?>>Per 6 Months</option>
                                  <option value="12" <?php echo $subscription['duration']==12 ? "selected":""; ?>>Per Year</option>
                                  <option value="24" <?php echo $subscription['duration']==24 ? "selected":""; ?>>Per 2 Years</option>
                                </select>
                                <input type="hidden" name="subscription_description" id="subscription_description" value="<?php echo $subscription['fee_description']; ?>">
                            </div>

                            <div class="form-group">
                                <label class="display-block">Subscription Status</label>
                                <label class="radio-inline">
                                    <input name="status" checked="checked" name="status" id="status1" value="1" type="radio" <?php echo $subscription['status']==1 ? "checked":""; ?>> Active
                                </label>
                                <label class="radio-inline">
                                    <input name="status" type="radio" name="status" id="status2" value="0" <?php echo $subscription['status']==0 ? "checked":""; ?>> Inactive
                                </label>
                            </div>
                            <div class="m-t-20">
                                <button class="btn btn-primary" type="submit">Update Changes</button>
                                <a href="<?php echo $base_url; ?>subscriptions" class="btn btn-link">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
