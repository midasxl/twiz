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

<!-- summary sheet filters modal to provide user filter options when viewing race sheets -->

<div class="modal fade" id="filters" tabindex="-1" role="dialog" aria-labelledby="filtersModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close closeFilterData" data-dismiss="modal" aria-hidden="true">&times;</button>
               <h4 class="modal-title" id="filtersModalLabel">Thoroughwiz Summary Sheet Filters</h4> 
            </div>
            <div class="modal-body">                        
                <div class="row">                            
                    <div class="col-md-12">
                        
<form method="post" action="scripts/summary.php" name="mainFilterForm" id="mainFilterForm" target='_blank'>
    
<input type='hidden' id='sheetId' name='card' value=''>
    
<div class="form-row">
    <div class="form-group col-md-4">
        <label class="form-check-label">Remove Trouble Lines?</label>
    </div>
    <div class="form-group col-md-8">
        <label class="form-check-label">
            <input class="form-check-input" type="radio" name="remTrLines" value="Yes" required> Yes
        </label>
        <label class="form-check-label">
            <input class="form-check-input" type="radio" name="remTrLines" value="No" checked> No
        </label>
    </div>
</div>
    
<div class="form-row">
    <div class="form-group col-md-4">
        <label class="form-check-label">Exclude OFF tracks?</label>
    </div>
    <div class="form-group col-md-8">
        <label class="form-check-label">
            <input class="form-check-input" type="radio" name="exclOffTracks" value="Yes" required> Yes
        </label>
        <label class="form-check-label">
            <input class="form-check-input" type="radio" name="exclOffTracks" value="No" checked> No
        </label>
    </div>
</div>
    
<div class="form-row">
    <div class="form-group col-md-4">
        <label class="form-check-label">Same surface as today?</label>
    </div>
    <div class="form-group col-md-8">
        <label class="form-check-label">
            <input class="form-check-input" type="radio" name="sameSurToday" value="Yes" required> Yes
        </label>
        <label class="form-check-label">
            <input class="form-check-input" type="radio" name="sameSurToday" value="No" checked> No
        </label>
    </div>
</div>
    
<label class="form-check-label">MAX Number of Races:</label><small class="form-text text-muted">&nbsp;&nbsp;Race range: 1-12</small>
    <input type="range" id="maxRaces" name="maxRaces" min="1" max="12" step="1" value="12" data-rangeslider><br><br>
    
<label class="form-check-label">Finish position of no worse than:</label><small class="form-text text-muted">&nbsp;&nbsp;Finish position range: 1-22</small>
    <input type="range" id="finPos" name="finPos" min="1" max="22" step="1" value="22" data-rangeslider><br><br>
    
<label class="form-check-label">Today's distance MINUS how many furlongs?</label><small class="form-text text-muted">&nbsp;&nbsp;i.e. 50 for 1/2f, 100 for 1f, 200 for 2f, etc.</small>
    <input type="range" id="distMinus" name="distMinus" min="0" max="250" step="50" value="250" data-rangeslider><br><br>
    
<label class="form-check-label">Today's distance PLUS how many furlongs?</label><small class="form-text text-muted">&nbsp;&nbsp;i.e. 50 for 1/2f, 100 for 1f, 200 for 2f, etc.</small>
    <input type="range" id="distPlus" name="distPlus" min="0" max="250" step="50" value="250" data-rangeslider><br><br>
    
<label class="form-check-label">Max number of days back for last race?</label>
    <input type="range" id="daysback" name="daysback" min="10" max="1000" step="28" value="1018" data-rangeslider><br><br>
    
<label class="form-check-label">Post time odds not more than?</label>
    <input type="range" id="oddstoday" name="oddstoday" min="0" max="100" step="1" value="100" data-rangeslider><br><br>

<div class="log-in-wrap col-md-12">
    <button type="button" class='btn btn-success pull-right closeFilterData' data-dismiss="modal"><i class="fa fa-times"></i>&nbsp;&nbsp;Close</button>
    <button type="submit" class="btn btn-success pull-right" style="margin-right:5px;" id="submitFilterData"><i class="fa fa-filter"></i>&nbsp;&nbsp;Apply Filters</button>
</div>
    
</form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- summary sheet filters modal to provide user filter options when viewing race sheets -->

<div class="modal fade" id="sampleFilters" tabindex="-1" role="dialog" aria-labelledby="sampleFiltersModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close closeFilterData" data-dismiss="modal" aria-hidden="true">&times;</button>
               <h4 class="modal-title" id="sampleFiltersModalLabel">Thoroughwiz Free Summary Sheet Filters</h4> 
            </div>
            <div class="modal-body">                        
                <div class="row">                            
                    <div class="col-md-12">
                        
<form method="post" action="scripts/summary_free.php" name="sampleFilterForm" id="sampleFilterForm" target='_blank'>
    
<div class="form-row">
    <div class="form-group col-md-4">
        <label class="form-check-label">Remove Trouble Lines?</label>
    </div>
    <div class="form-group col-md-8">
        <label class="form-check-label">
            <input class="form-check-input" type="radio" name="remTrLines" value="Yes" required> Yes
        </label>
        <label class="form-check-label">
            <input class="form-check-input" type="radio" name="remTrLines" value="No" checked> No
        </label>
    </div>
</div>
    
<div class="form-row">
    <div class="form-group col-md-4">
        <label class="form-check-label">Exclude OFF tracks?</label>
    </div>
    <div class="form-group col-md-8">
        <label class="form-check-label">
            <input class="form-check-input" type="radio" name="exclOffTracks" value="Yes" required> Yes
        </label>
        <label class="form-check-label">
            <input class="form-check-input" type="radio" name="exclOffTracks" value="No" checked> No
        </label>
    </div>
</div>
    
<div class="form-row">
    <div class="form-group col-md-4">
        <label class="form-check-label">Same surface as today?</label>
    </div>
    <div class="form-group col-md-8">
        <label class="form-check-label">
            <input class="form-check-input" type="radio" name="sameSurToday" value="Yes" required> Yes
        </label>
        <label class="form-check-label">
            <input class="form-check-input" type="radio" name="sameSurToday" value="No" checked> No
        </label>
    </div>
</div>
    
<label class="form-check-label">MAX Number of Races:</label><small class="form-text text-muted">&nbsp;&nbsp;Race range: 1-12</small>
    <input type="range" id="maxRaces" name="maxRaces" min="1" max="12" step="1" value="12" data-rangeslider><br><br>
    
<label class="form-check-label">Finish position of no worse than:</label><small class="form-text text-muted">&nbsp;&nbsp;Finish position range: 1-22</small>
    <input type="range" id="finPos" name="finPos" min="1" max="22" step="1" value="22" data-rangeslider><br><br>
    
<label class="form-check-label">Today's distance MINUS how many furlongs?</label><small class="form-text text-muted">&nbsp;&nbsp;i.e. 50 for 1/2f, 100 for 1f, 200 for 2f, etc.</small>
    <input type="range" id="distMinus" name="distMinus" min="0" max="250" step="50" value="250" data-rangeslider><br><br>
    
<label class="form-check-label">Today's distance PLUS how many furlongs?</label><small class="form-text text-muted">&nbsp;&nbsp;i.e. 50 for 1/2f, 100 for 1f, 200 for 2f, etc.</small>
    <input type="range" id="distPlus" name="distPlus" min="0" max="250" step="50" value="250" data-rangeslider><br><br>
    
<label class="form-check-label">Max number of days back for last race?</label>
    <input type="range" id="daysback" name="daysback" min="10" max="1000" step="28" value="1018" data-rangeslider><br><br>
    
<label class="form-check-label">Post time odds not more than?</label>
    <input type="range" id="oddstoday" name="oddstoday" min="0" max="100" step="1" value="100" data-rangeslider><br><br>

<div class="log-in-wrap col-md-12">
    <button type="button" class='btn btn-success pull-right closeSampleFilterData' data-dismiss="modal"><i class="fa fa-times"></i>&nbsp;&nbsp;Close</button>
    <button type="submit" class="btn btn-success pull-right" style="margin-right:5px;" id="submitSampleFilterData"><i class="fa fa-filter"></i>&nbsp;&nbsp;Apply Filters</button>
</div>
    
</form>

                    </div>
                </div>
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
