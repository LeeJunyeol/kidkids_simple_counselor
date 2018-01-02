import { AsideModule, CommonModule } from "./common";
import { NaverLogin, KakaoLogin } from "./snslogin";
import Properties from "../properties";

$(document).ready(() => {
  AsideModule.init();
  CommonModule.init();

  NaverLogin.init();
  Kakao.init(Properties.kakaoKey);
  KakaoLogin.init(1);
});
