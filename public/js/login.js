import { AsideModule, CommonModule } from "./common";
import { HandlebarsHelper, Utils } from "./util";
import Properties from "../properties";

$(document).ready(() => {
  AsideModule.init();
  CommonModule.init();

  NaverLogin.init();
  Kakao.init(Properties.kakaoKey);
  KakaoLogin.init();
});

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

var KakaoLogin = (function() {
  var init = () => {
    $("#kakaoIdLogin").on("click", loginWithKakao);
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
  return {
    init
  };
})();