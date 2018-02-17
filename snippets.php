Standard Deviation: <span id="stdDev"></span>

<!-- what this script does:

Standard Deviation is found by taking the square root of the average of
the squared differences of the values from their average value.

1. get the average value of the data sheet
2. calculate the difference between each value in the set and the average
3. square the result of each difference
4. average the squared differences
5. get the square root of the average squared difference -->

<!-- JS Global Compulsory -->
<script type="text/javascript" src="assets/plugins/jquery-1.10.2.min.js"></script>

<script>
function standardDeviation(values){

    // get the average of the data set
    var avg = average(values); // call average function

    // calculate difference between each array value and the average value
    // map function will iterate over array items an return a new array of these values
    var squareDiffs = values.map(function(value){
      var diff = value - avg;
      // square the differences of each value in this step as well
      var sqrDiff = diff * diff;
      return sqrDiff;
    });
    // get the average of the squared differences
    var avgSquareDiff = average(squareDiffs); // call average function
    // calculate the square root of the average squared differences
    // final result is the standard deviation for the data set
    var stdDev = Math.sqrt(avgSquareDiff);
    return stdDev;
}

function average(data){
  // reduce iterates over every array value and produces a single result
  // produces a sum of all the item in the array
  var sum = data.reduce(function(sum, value){
    return sum + value;
  }, 0);
  // divide the sum by the number of items in the array to get average
  var avg = sum / data.length;
  return avg;
}

// function fires on page load
$(function(){
  // pass in an array of values
  var stdDev = standardDeviation([1, 2, 3, 4, 5, 6, 7, 8, 9, 25]);
  // display result in the container
  $("#stdDev").text(stdDev);
});
</script>
