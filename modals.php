<!-- These are all the modals (popups) used by Thoroughwiz -->

<!-- global twiz responder -->

<div id="form-messages" title="Thoroughwiz says..." style="text-align:center;padding:5px;"></div>

<!-- log in, log out responder -->

<div id="logInDiv" title="Logging In" style="display:none;text-align:center;padding:5px;">
    <img src="img/loading11.gif" alt="loading" />
</div>

<div id="logInGood" title="You're In!" style="text-align:center;padding:5px;"></div>

<div id="logOutDiv" title="Logging Out" style="display:none;text-align:center;padding:5px;">
    <img src="img/loading11.gif" alt="loading" />
</div>

<!-- password change confirmation (could this be consolidated with the global?)-->

<div id="passChangeDiv" title="Thoroughwiz says..." style="text-align:center;padding:5px;"></div>

<!-- user delete race sheets responder -->

<div id="dialog-confirm" title="Delete this set of race sheets?"></div>

<div id="delSheetDiv" title="Deleting Sheet Set" style="display:none;text-align:center;padding:5px;">
    <img src="img/loading11.gif" alt="loading" />
</div>

<!-- you must agree to the thoroughwiz terms of service.  I believe this is on the xml upload forms -->

<div id="dialogDetails" title="Thoroughwiz says..." style="text-align:center;padding:5px;"></div>

<!-- resources modal available in the header -->

<div class="modal fade" id="resources" tabindex="-1" role="dialog" aria-labelledby="resourcesModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="resourcesModalLabel">Thoroughwiz Resources</h4>
            </div>
            <div class="modal-body">                        
                <div class="row">                            
                    <div class="col-md-8">
                        <ul>

                        <li><a href="http://www.equibase.com/live.cfm" target="_blank">Equibase Live Racing Calendar</a></li>
                        <li><a href="http://theturfclub.yolasite.com/the-lobby.php" target="_blank">The Turf Club</a></li>
                        <li><a href="http://www.twinspires.com/brisnet/carryovers" target="_blank">Carry Overs</a></li>
                        <li><a href="http://www.twinspires.com/simulcast" target="_blank">Twinspires simulcast calendar</a></li>
                        <li><a href="http://thoroughbreddailynews.com" target="_blank">Thoroughbred Daily News</a></li>
                        <li><a href="http://equidaily.com" target="_blank">Equidaily</a></li>
                        <li><a href="http://www.brisnet.com/cgi-bin/HTML/racingnews.html" target="_blank">Handicappers Edge (brisnet)</a></li>
                        <li><a href="http://paceadvantage.com" target="_blank">Pace Advantage</a></li>
                        <li><a href="http://www.offtrackbetting.com/graded_stakes_results.html" target="_blank">Graded Stakes results/schedule (offtrackbetting.com)</a></li>
                        <li><a href="http://www.trks2day.com/trks2day.html" target="_blank">WhoBet's BRISWATCH data</a></li>	
                        <li><a href="http://mobile.equibase.com/html/scratches.html" target="_blank">Scratches</a></li>	
                        <li><a href="https://www.americanturf.com" target="_blank">American Turf Monthly</a></li>
                        <li><a href="https://issuu.com/horseplayernow" target="_blank">Horse Player Now</a></li>

                        </ul>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class='btn btn-success' data-dismiss="modal"><i class="fa fa-times"></i>&nbsp;&nbsp;Close</button>
            </div>
        </div>
    </div>
</div>

<!-- promo modal for Kentucky Derby (legacy purposes) -->

<!-- Images in Bootstrap are made responsive with .img-fluid. max-width: 100%; and height: auto; are applied to the image so that it scales with the parent element. -->

<!--<div class="modal-promo fade" id="promo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog-promo">
        <div class="modal-content-promo">
            <div class="modal-header-promo">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title-promo" id="myModalLabel">Kentucky Derby Promotion</h4>
            </div>
            <div class="modal-body-promo">                        
                <div class="row">                            
                    <div class="col-md-12 img-content-holder">

                    </div>
                </div>
            </div>
            <div class="modal-footer-promo">
                <a href="promo-access.php" class="btn btn-success">Let's Do This!</a>
                <button type="button" class='btn btn-success' data-dismiss="modal">Let's Do This!</button>
            </div>
        </div>
    </div>
</div>-->
