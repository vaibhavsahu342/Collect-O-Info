(function () {
    navigator.geolocation.getCurrentPosition(function (position) {
       console.log(position.coords.latitude)
       console.log(position.coords.longitude)

       let data = null;

       fetch(`http://api.positionstack.com/v1/reverse?access_key=0bfac293ecd8db65ff5f003448462ea9&query=${position.coords.latitude}, ${position.coords.longitude}&limit=1`)
            .then(response => {
                return response.json();

            })
            .then(users => {
                console.log(users);
                // console.log(users.data[0].latitude);
                
                $.ajax({
                    url:"user_info_track.php",
                    method:"post",
                    data: {users:JSON.stringify(users)},
                    success: function(res) {
                        console.log(res);
                    }
                })

                // window.location.replace("http://localhost:8000/vipra-backup-new/geolocation/user_info_track.php");
            });
        
        
    },
    function (error) {
        console.log("The Locator was denied. :(")
    })
})();