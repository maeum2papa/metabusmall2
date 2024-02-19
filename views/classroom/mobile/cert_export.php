<!-- html2canvas 라이브러리 추가 -->
<script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
<section class="cert_layout" id="asmo_classroom">
    <div id="asmo_classroom_myClass">
    <button type="button" id="export_cert">저장하기</button>
    <div id="cert" class="cert_inner" style="background-color: #fff;">
        <article class="cert_top">
            <h2>교육 이수 확인서</h2>
            <div>
                <dl>
                    <dt>기업명</dt>
                    <dd><?php echo element('company_name', element('post', $view)); ?></dd>
                </dl>
                <dl>
                    <dt>소속</dt>
                    <dd><?php echo element('mem_div', element('post', $view)); ?></dd>
                </dl>
                <dl>
                    <dt>성명</dt>
                    <dd><?php echo element('mem_username', element('post', $view)); ?></dd>
                </dl>
            </div>
        </article>
        <article class="cert_mid">
            <h4>교육정보</h4>
            <div>
                <dl>
                    <dt>교육 형태</dt>
                    <dd>온라인 자체 교육</dd>
                </dl>
                <dl>
                    <dt>교육 지원</dt>
                    <dd>주식회사 팀메타 - 컬래버랜드 시스템</dd>
                </dl>
                <dl>
                    <dt>교육 형식</dt>
                    <dd>동영상 교육</dd>
                </dl>
                <dl>
                    <dt>교육 과정</dt>
                    <dd><?php echo element('p_title', element('post', $view)); ?></dd>
                </dl>
                <dl>
                    <dt>교육 시간</dt>
                    <dd><?php echo element('p_time', element('post', $view)); ?></dd>
                </dl>
                <dl>
                    <dt>발급 일자</dt>
                    <dd><?php echo element('cert_date', element('post', $view)); ?></dd>
                </dl>
            </div>
        </article>
        <article class="cert_bot">
            <h4>위 사람은 컬래버랜드를 서비스하는 팀메타원격평생교육원의<br>「<?php echo element('p_title', element('post', $view)); ?>」 교육을<br>이수하였음을 증명합니다.</h4>
        </article>
    </div>
    <button type="button" class="btn btn-default" id="history_back">이전페이지로</button>
    </div>
</section>
<!-- jsPDF 및 JSZip 라이브러리 추가 -->
<script src="/assets/js/jspdf.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.5/jszip.min.js"></script>
<!-- FileSaver.js 라이브러리 추가 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>
<script>
    //asmo lhb 231218 클래스 영역 구분용 클래스 추가
	document.querySelector('.main').classList.add('asmo_m_layout');
    $(document).ready(function(){
        $('#export_cert').click(function(){
            html2canvas($('#cert')[0]).then(function(canvas){
                var imgData = canvas.toDataURL('image/png');
                var imgWidth = 210;
                var pageHeight = imgWidth * 1.414;
                var imgHeight = canvas.height * imgWidth / canvas.width;
                var heightLeft = imgHeight;
                var margin = 0;
                var doc = new jsPDF('p', 'mm');
                var position = 0;

                doc.addImage(imgData, 'PNG', margin, position, imgWidth, imgHeight);
                heightLeft -= pageHeight;

                doc.save('cert_<?=$view['post']['p_title'];?>_<?=$view['post']['mem_username'];?>.pdf');
            });
        });
    });

    document.getElementById('history_back').onclick = function(){
        window.history.back();
    }
</script>