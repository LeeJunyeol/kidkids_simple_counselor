import { HandlebarsHelper, Utils } from "./util";
import Properties from "../properties";

var NaverLogin = new naver.LoginWithNaverId({
  clientId: Properties.naverClientId,
  callbackUrl: location.origin + "/naver-callback",
  isPopup: false /* 팝업을 통한 연동처리 여부 */,
  loginButton: {
    color: "green",
    type: 3,
    height: 60
  } /* 로그인 버튼의 타입을 지정 */
});

var NaverConnect = (() => {
  var init = () => {
    $("#sns-body").on("click", "#naverIdConn", naverConnect);
    $("#sns-body").on("click", "#naverIdDisconn", naverDisconn);
  }

  var naverDisconn = (e) => {
    var url = location.origin + "/naverdisconn";
    
    $.ajax(url, {
      type: "PUT",
      contentType: "application/json"
    }).then(res => {
      console.log(res);
    })
  }

  var naverConnect = (e) => {
    var url = "https://nid.naver.com/oauth2.0/authorize?response_type=code&"
    + "client_id=" + Properties.naverClientId
    + "&state=STATE_STRING"
    + "&auth_type=reauthenticate"
    + "&redirect_uri=" + location.origin + "/naver-connect-callback";

    location.href = url;
  }
  return {
    init
  }
})();

var KakaoLogin = (function() {
  var init = (mode) => {
    if(mode === 1){
      $("#kakaoIdLogin").on("click", loginWithKakao);
    } else {
      $("#kakaoIdLogin").on("click", connectWithKakao);
    }
  };

  //<![CDATA[
  // 사용할 앱의 JavaScript 키를 설정해 주세요.
  function loginWithKakao() {
    // 로그인 창을 띄웁니다.
    Kakao.Auth.login({
      success: function(authObj) {
        // 로그인 성공시, API를 호출합니다.
        Kakao.API.request({
          url: "/v1/user/me",
          success: function(res) {
            var user = {};
            user.id = res.id;
            user.email = res.kaccount_email;
            user.name = res.properties.nickname;
            user.pic = res.properties.profile_image;

            $.ajax(location.origin + "/api/User/kakaologin", {
              type: "POST",
              contentType: "application/json",
              data: JSON.stringify(user)
            }).then(function(res) {
              window.location.replace(
                "http://" +
                  window.location.hostname +
                  (location.port == "" || location.port == undefined
                    ? ""
                    : ":" + location.port) +
                  "/home"
              );
            });
          },
          fail: function(error) {
            alert(JSON.stringify(error));
          }
        });
      },
      fail: function(err) {
        alert(JSON.stringify(err));
      }
    });
  }

  function connectWithKakao() {
    // 로그인 창을 띄웁니다.
    Kakao.Auth.login({
      success: function(authObj) {
        // 로그인 성공시, API를 호출합니다.
        Kakao.API.request({
          url: "/v1/user/me",
          success: function(res) {
            var user = {};
            user.id = res.id;
            user.email = res.kaccount_email;
            user.name = res.properties.nickname;
            user.pic = res.properties.profile_image;

            $.ajax(location.origin + "/api/User/kakaoconn", {
              type: "POST",
              contentType: "application/json",
              data: JSON.stringify(user)
            }).then(function(res) {
              console.log(res);
            });
          },
          fail: function(error) {
            alert(JSON.stringify(error));
          }
        });
      },
      fail: function(err) {
        alert(JSON.stringify(err));
      }
    });
  }

  return {
    init
  };
})();

export { NaverConnect, KakaoLogin, NaverLogin }