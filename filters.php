<form method="post" action="filtersDump.php" name="mainFilterForm" id="mainFilterForm" target='_blank'>
    
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