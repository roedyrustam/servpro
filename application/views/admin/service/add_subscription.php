<div class="page-wrapper">
            <div class="content container-fluid">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <h4 class="page-title">Add Subscription</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <form id="addSubscription" method="post">
                            <div class="form-group">
                                <label>Subscription Name</label>
                                <input class="form-control" type="text" placeholder="Free Trial" name="subscription_name" id="subscription_name">
                            </div>
                            <div class="form-group">
                                <label>Subscription Amount</label>
                                <input class="form-control" type="number" step="0.01" min="0" name="amount" id="amount">
                            </div>
                            <div class="form-group">
                                <label>Subscription Durations</label>
                                <select class="form-control" name="duration" id="duration">
                                  <option value="">Select Duration</option>
                                  <option value="1">Per Month</option>
                                  <option value="3">Per 3 Months</option>
                                  <option value="6">Per 6 Months</option>
                                  <option value="12">Per Year</option>
                                  <option value="24">Per 2 Years</option>
                                </select>
                                <input type="hidden" name="subscription_description" id="subscription_description" value="">
                            </div>
                            <div class="form-group">
                                <label class="display-block">Subscription Status</label>
                                <label class="radio-inline">
                                    <input checked="checked" type="radio" name="status" id="status1" value="1"> Active
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="status" id="status2" value="0"> Inactive
                                </label>
                            </div>
                            <div class="m-t-20">
                                <button class="btn btn-primary" type="submit">Publish Subscription</button>
                                 <a href="<?php echo $base_url; ?>subscriptions" class="btn btn-link">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
