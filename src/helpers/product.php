<?php

namespace utils\product;

global $fieldMergeGroups;
// Attributes defined in "values" will be merged under the name of "key"
// This makes it easier to add new groups in the future
$fieldMergeGroups = [
  "dimensions" => ['height', 'width', 'length']
];

// Input format Array ( [weight] => 2.00 )
// Check if there are existing fields for all the values of a key from fieldMergeGroups
function joinFields($productFields)
{
  global $fieldMergeGroups;

  $productFieldsToReturn = $productFields;

  foreach ($fieldMergeGroups as $key => $group) {
    // need to make second copy in case there are more than 1 merge groups to process
    $copyFields = $productFieldsToReturn;
    $newFieldValues = [];
    $fieldType = null;
    $allTheGroupFieldsExist = true;

    foreach ($group as $field) {
      // If all the fields of a group doesnt exist in product break the loop
      // If the value exist keep adding them to the list
      $fieldType;
      $allTheGroupFieldsExist;

      if (!isset($productFields[$field])) {
        $allTheGroupFieldsExist = null;
        break;
      };
      unset($copyFields[$field]);
      array_push($newFieldValues, $productFields[$field][0]);
      $fieldType = $productFields[$field][1];
    }
    // If the loop didnt break it means product has all the fields for a given merge group
    // and we already saved them into an array.
    // and we already removed the fields from the copy of the fields.
    // now merge and add these values as a new field to the copy of the field group.

    if ($allTheGroupFieldsExist) {
      $copyFields[$key] = [join('x', $newFieldValues), $fieldType];
      $productFieldsToReturn = $copyFields;
    }
  }
  return $productFieldsToReturn;
}