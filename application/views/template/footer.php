<!-- Button trigger modal -->
<button type="button" class="btn btn-primary chat" <?= $footer ?> onclick="callChat()">
    <i class="fas fa-headset mr-2"></i>ChatBot
</button>
<div class="card chat length d-none" style="z-index: 5;" id="cardChat">
    <div class="card-header text-white d-flex justify-content-between align-items-center" <?= $header ?>>
        <span>
            <i class="fas fa-headset mr-2"></i>ChatBot
        </span>
        <button class="btn-custom" onclick="closeChat()"><i class="fas fa-close"></i></button>
    </div>
    <div class="card-body border chtbot">
        <div id="chat" class="scroller-content">
            <div class="d-flex flex-row justify-content-start item">
                <div class="p-3 ms-3" style="border-radius: 15px; background-color: rgba(57, 192, 237,.2);">
                    <p class="small mb-0">Adakah yang bisa saya bantu?</p>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer" <?= $footer ?>>
        <form class="form-inline d-flex flex-nowrap" onsubmit="handle(event)">
            <input type="text" class="form-control col-10 mr-2 ml-n1 small" id="data" placeholder="Type message">
            <button id="send" class="btn btn-primary col-2"><i class="fas fa-paper-plane"></i></button>
        </form>
    </div>
</div>
<script>
    function callChat() {
        var target = document.getElementById("cardChat");
        target.classList.replace("d-none","d-block");
        document.getElementById("data").focus();
    }

    function handle(e){
        e.preventDefault(); // Ensure it is only this code that runs
    }

    $(document).ready(function(){
        $("#send").on("click", function(){
            $value = $("#data").val();
            $msg = "<div id='conversation' class='d-flex flex-row justify-content-end mt-4'><div class='p-3 me-3 border' style='border-radius: 15px; background-color: #fbfbfb;'><p class='small mb-0'>"+ $value +"</p></div></div>"
            $("#chat").append($msg);
            $("#data").val('');

        $.ajax({
            url:'<?= site_url("home/chat") ?>',
            type: 'POST',
            data: 'text='+$value,
            success:function(result){
                $replay = "<div id='conversation' class='d-flex flex-row justify-content-start mt-4'><div class='p-3 ms-3' style='border-radius: 15px; background-color: rgba(57, 192, 237,.2);'><p class='small mb-0'>"+ result +"</p></div></div>"
                $("#chat").append($replay);
            }
        })
        })
    })

    function closeChat() {
        var target = document.getElementById("cardChat");
        target.classList.replace("d-block", "d-none");
    }

</script>
</body>
</html>