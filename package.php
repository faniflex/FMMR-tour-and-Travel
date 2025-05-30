<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="form.css">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
   </head>
<body>
  <div class="container">
    <div class="title">Design Your tour</div>
    <div class="content">
      <form action="connect.php" method="post">
        <div class="user-details">
          <div class="input-box">
            <span class="details">Full Name</span>
            <input type="text" placeholder="Enter your name" name="fname" autocomplete="off" required>
          </div>
          <div class="input-box">
            <span class="details">Arrival Date</span>
            <input type="date" name="arrival_date" autocomplete="off" required>
          </div>
          <div class="input-box">
            <span class="details">Email</span>
            <input type="email" name="email" placeholder="Enter your email" autocomplete="off" required>
          </div>
          <div class="input-box">
            <span class="details">Departure Date</span>
            <input type="Date" name="departure_date" autocomplete="off" required>
          </div>
          <div class="input-box">
            <span class="details">Phone Number</span>
            <input type="tel" name="phone_number" placeholder="Enter your number" autocomplete="off" required>
          </div>
          <div class="input-box">
            <span class="details">Address</span>
            <input type="text" name="address" placeholder="Enter your address" autocomplete="off" required>
          </div>
          <div class="input-box">
            <span class="details" for="distination">Distination</span>
            <input list="distinations" name="distination" id="distination"  placeholder="Hamer" autocomplete="off">
            <datalist id="distinations" >
              <option value="Ras Dashen">
              <option value="Hamer">
              <option value="Entoto Park">
              <option value="Tiya">
              <option value="Fasil">
              <option value="Ertale">
            </datalist>
          </div>
          <div class="input-box">
            <span class="details" for="special">Special Packages</span>
            <input list="specials" name="special_packages" id="special"  placeholder="Lalibela" autocomplete="off">
            <datalist id="specials" >
              <option value="Lalibela">
              <option value="Dallol">
              <option value="Aksum">
            </datalist>
          </div>
          <div class="input-box">
            <span class="details" for="adult">Adult</span>
            <input type="number" id="adult" name="adult" min="1" max="10" value="1" autocomplete="off" required>
          </div>
          
          <div class="input-box">
            <span class="details" for="Child">Child</span>
            <input type="number" id="child" name="child" min="0" max="10" value="0" autocomplete="off" required>
          </div>
          <div class="input-box">
            <span class="details" for="room-type">Room Type</span>
            <input list="room-types" name="room-type" id="room-type"  placeholder="Single Room" autocomplete="off" required>
            <datalist id="room-types" >
              <option value="Single Room">
              <option value="Double Room">
              <option value="Twin Room">
              <option value="Queen Room">
              <option value="King Room">
              <option value="Tent">
            </datalist>
        
          </div>
          <div class="input-box">
            <span class="details" for="guide">Guide</span>
            <input list="guides" name="guide" id="guide"  placeholder="YES" autocomplete="off" required>
            <datalist id="guides" >
              <option value="YES">
              <option value="NO">
            </datalist>
          </div>
        </div>
        <div class="gender-details">
          <input type="radio" name="gender" value="male" id="dot-1" required>
          <input type="radio" name="gender" value="female" id="dot-2" required>
          <input type="radio" name="gender" value="prefer not to say" id="dot-3" required>
          <span class="gender-title">Gender</span>
          <div class="category">
            <label for="dot-1">
            <span class="dot one"></span>
            <span class="gender">Male</span>
          </label>
          <label for="dot-2">
            <span class="dot two"></span>
            <span class="gender">Female</span>
          </label>
          <label for="dot-3">
            <span class="dot three"></span>
            <span class="gender">Prefer not to say</span>
            </label>
          </div>
        </div>
        <div class="button">
          <input type="reset" value="Clear Form">
        </div>
        <div class="button">
          <input type="submit" name="Register" value="Register">
        </div>
      </form>
    </div>
  </div>

<script>
document.querySelector('form').addEventListener('submit', function(e) {
    const arrival = new Date(document.querySelector('input[name="arrival_date"]').value);
    const departure = new Date(document.querySelector('input[name="departure_date"]').value);
    
    if (arrival >= departure) {
        alert('Departure date must be after arrival date');
        e.preventDefault();
    }
    
    const phone = document.querySelector('input[name="phone_number"]').value;
    if (!/^[0-9+]{10,15}$/.test(phone)) {
        alert('Please enter a valid phone number');
        e.preventDefault();
    }
});
</script>
  
</body>
</html>
