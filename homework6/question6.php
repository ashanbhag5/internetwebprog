<?php
function getCarDetail(array $car, ?string $detail = null): string {
  // If the detail is provided and exists in the car array, return that detail
  if ($detail && isset($car[$detail])) {
      return $car[$detail];
  }
  // Otherwise, return a default message
  return "Car details: " . implode(", ", $car);
}

// Example array
$car = array("brand" => "Ford", "model" => "Mustang", "year" => 1964);

// Call the function with an optional parameter
echo getCarDetail($car, "brand") . "\n"; // Output: Ford
echo "<br>";

// Call the function without the optional parameter
echo getCarDetail($car); // Output: Car details: Ford, Mustang, 1964
echo "<br>";

$car = array("brand"=>"Ford", "model"=>"Mustang", "year"=>1964);
foreach ($car as $x => $y) {
  echo "$x: $y <br>";
}
?>