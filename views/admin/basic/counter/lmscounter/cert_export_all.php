<!-- html2canvas 라이브러리 추가 -->
<script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
<button type="button" id="export_cert">저장하기</button>
<section class="cert_layout">
    <?php foreach(element('post', $view) as $k => $v){ ?>
    <div id="cert_<?php echo element('mp_sno', $v);?>" class="cert_inner" style="background-color: #fff;">
        <input type="hidden" name="p_title" value="<?php echo element('p_title', element('post', $view));?>">
        <input type="hidden" name="mem_username" value="<?php echo element('mem_username', element('post', $view));?>">
        <article class="cert_top">
            <h2>교육 이수 확인서</h2>
            <div>
                <dl>
                    <dt>기업명</dt>
                    <dd><?php echo element('company_name', $v); ?></dd>
                </dl>
                <dl>
                    <dt>소속</dt>
                    <dd><?php echo element('mem_div', $v); ?></dd>
                </dl>
                <dl>
                    <dt>성명</dt>
                    <dd><?php echo element('mem_username', $v); ?></dd>
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
                    <dd><?php echo element('p_title', $v); ?></dd>
                </dl>
                <dl>
                    <dt>교육 시간</dt>
                    <dd><?php echo element('p_time', $v); ?></dd>
                </dl>
                <dl>
                    <dt>발급 일자</dt>
                    <dd><?php echo element('cert_date', $v); ?></dd>
                </dl>
            </div>
        </article>
        <article class="cert_bot">
            <h4>위 사람은 컬래버랜드를 서비스하는 팀메타원격평생교육원의<br>「<?php echo element('p_title', $v); ?>」 교육을<br>이수하였음을 증명합니다.</h4>
        </article>
    </div>
    <?php } ?>
    <button type="button" class="btn btn-default" id="history_back">이전페이지로</button>
</section>
<!-- jsPDF 및 JSZip 라이브러리 추가 -->
<script src="/assets/js/jspdf.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.5/jszip.min.js"></script>
<!-- FileSaver.js 라이브러리 추가 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>
<script>
    $(document).ready(function(){
        $('#export_cert').click(function(){
            var zip = new JSZip();
            var promises = [];
            <?php foreach(element('post', $view) as $k => $v){ ?>
                var sectionId = 'cert_<?=$v['mp_sno'];?>';
                var section = document.getElementById(sectionId);
                if(section){
                    promises.push(html2canvas(section, {
                        // 이미지 화질 조절
                        scale: 3, // 높은 값으로 조절하여 화질 향상

                        // 페이지 크기 설정
                        windowWidth: section.clientWidth,
                        windowHeight: section.clientHeight
                    }).then(function(canvas){
                        var imgData = canvas.toDataURL('image/png');
                        var pdf = new jsPDF('p', 'mm');

                        // 이미지 비율 계산
                        var imgWidth = pdf.internal.pageSize.getWidth();
                        var imgHeight = canvas.height * imgWidth / canvas.width;

                        pdf.addImage(imgData, 'PNG', 0, 0, imgWidth, imgHeight);
                        zip.file('cert_<?=$v['p_title'];?>_<?=$v['mem_username'];?>.pdf', pdf.output('blob'));
                    }));
                } else {
                    console.error('Section element not found for ID: ' + sectionId);
                }

            <?php } ?>
            
            Promise.all(promises).then(function() {
                zip.generateAsync({type: 'blob'}).then(function(content) {
                    saveAs(content, 'certificates.zip');
                });
            });
        });
    });

    document.getElementById('history_back').onclick = function(){
        window.history.back();
    }
</script>