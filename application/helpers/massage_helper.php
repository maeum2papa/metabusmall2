<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * basic_helper.php 에 include 되어 있음
 * 사용법 <?php echo cmsg("1100");?>
 */
if ( ! function_exists('cmsg')) {
    /**
     * 모든 메세지 모음 메소드
     * @param String $code 메세지코드
     * @return String 메세지
     * 
     * 0000
     * 1자리 : 메세지 분류 (상품, 주문, 회원 ...) 
     * 2자리 : 메세지 종류 (경고, 일반 ...)
     * 3자리 : 예비
     * 4자리 : 예비
     * 
     * 0*** : 공통
     * 1*** : 상품
     * 2*** : 주문
     * 3*** : 결제
     * 4*** : 주문내역
     * 5*** : 게시판
     * 
     * *0** : 일반
     * *1** : 경고
     * 
     */
    function cmsg($code){

        $msg = array(
            "0100"=>"잘못된 접근 입니다.",
            "0101"=>"로그인이 필요한 서비스 입니다.",
            "1100"=>"삭제된 상품 입니다.",
            "1101"=>"품절된 상품 입니다.",
            "1102"=>"한번만 구매할 수 있는 상품 입니다.",
            "1103"=>"베타테스트 기간에는 구매가 불가합니다",
            "2100"=>"품절된 상품이 포함되어 있습니다.",
            "2101"=>"주문 가능한 상품이 없습니다.",
            "2102"=>"열매 상품과 코인 상품을 함께 주문할 수 없습니다.",
            "2103"=>"보유 열매가 부족합니다.",
            "2104"=>"보유 코인이 부족합니다.",
            "3100"=>"열매 상품과 코인 상품을 함께 주문할 수 없습니다.",
            "3101"=>"삭제된 상품이 포함되어 있습니다.",
            "3102"=>"주소 입력은 필수값 입니다.",
            "3103"=>"품절된 상품이 포함되어 있습니다.",
            "3104"=>"자사몰 상품은 코인으로 결제할 수 없습니다.",
            "3105"=>"결제 시 필요한 열매가 부족합니다.",
            "3106"=>"결제 시 필요한 코인이 부족합니다.",
            "3107"=>"결제 시 필요한 기업 예치금이 부족합니다.",
            "4000"=>"주문이 취소 되었습니다.",
            "4100"=>"주문취소할 수 없는 아이템 상품이 포함되어 있습니다.",
            "4101"=>"전체 취소할 수 없는 주문 입니다.",
            "5000"=>"관리자에서 확인하실 수 있습니다."
        );
        
        $result = ($msg[$code])?$msg[$code]:"";

        return $result;
    }
}