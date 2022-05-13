// Sumbit changes to form, default to GET
function formChange(type = "GET") {
  let element = document.getElementById("form-change");
  // Set type to GET/POST
  element.method = type;
  // Submit form
  element.submit();
}

// Set all filter selections to default
function clearFilters(submit = true) {
  document.getElementById("authorID").value = 0;
  document.getElementById("categoryID").value = 0;
  document.getElementById("authorIDSubmit").value = 0;
  document.getElementById("categoryIDSubmit").value = 0;
  // Submit changes
  submit ? this.formChange() : null;
}

// Close filter group and open submission form
function openSubmit() {
  document.getElementById("filter-grp").style.display = "none";
  document.getElementById("quote-container").style.display = "none";
  document.getElementById("submit-grp").style.display = "block";
  clearFilters(false);
}

// Open filter group and close submission form
function closeSubmit() {
  document.getElementById("filter-grp").style.display = "block";
  document.getElementById("quote-container").style.display = "block";
  document.getElementById("submit-grp").style.display = "none";
}

// Validate form meets criteria before submission
function checkValid(submit = false) {
  let count = 0;
  // If element does not meet validation requirments, increment count
  document.getElementById("categoryIDSubmit").value == 0 ? count++ : "";
  document.getElementById("authorIDSubmit").value == 0 ? count++ : "";
  document.getElementById("textsubmit").value.length < 10 ? count++ : "";
  // If count has value, validation failed. Update submit form if valid
  if (count == 0) {
    document.getElementById("submit-quote-btn").classList.remove("disabled");
    document.getElementById("warning").innerHTML = "";
  } else {
    document.getElementById("submit-quote-btn").classList.add("disabled");
  }
  // Submission request made, submit if no errors
  if (submit == true) {
    if (count == 0) {
      document.getElementById("action").value = "submit";
      formChange("POST");
    } else {
      document.getElementById("warning").innerHTML = "Must Complete Form";
    }
  }
}

// Open appropriate nav page based on selection
function navControl(action) {
  // Clear URL Params
  history.pushState(null, "", location.href.split("?")[0]);
  const navControl = document.getElementById("admin-control");
  let navInput = document.getElementById("admin-input");
  // Set navigation to action param
  navInput.value = action;
  // Submit form
  navControl.submit();
}

// Delete database entry
// Params Primary ID and DB Table to delete from
function updateEntry(ID, type) {
  document.getElementById("quoteID").value = ID;
  document.getElementById("action").value = type;
  // Submit form as POST
  this.formChange("POST");
}

