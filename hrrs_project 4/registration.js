function showFields() {
    var userType = document.getElementById("user_type").value;
    var personalInfoSection = document.getElementById("personal_info_section");
    var idCardField = document.getElementById("id_card_field");
    var panField = document.getElementById("pan_field");
    var registerButton = document.getElementById("register_button");

    personalInfoSection.style.display = "block";
    registerButton.style.display = "block";

    if (userType === "") {
      personalInfoSection.style.display = "none";
      registerButton.style.display = "none";
    } else if (userType === "student") {
      idCardField.style.display = "block";
      panField.style.display = "none";
    } else if (userType === "owner") {
      idCardField.style.display = "none";
      panField.style.display = "block";
    }
  }

  function showPreview(input, previewId) {
    var preview = document.getElementById(previewId);
    var files = input.files;

    if (files && files[0]) {
      var reader = new FileReader();

      reader.onload = function (e) {
        preview.src = e.target.result;
      }

      reader.readAsDataURL(files[0]);
      preview.style.display = "block";
    } else {
      preview.style.display = "none";
    }
  }