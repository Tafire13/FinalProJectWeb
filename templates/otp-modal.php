<div id="otpModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white w-full max-w-md rounded-xl p-6 shadow-xl">

        <h2 class="text-xl font-bold mb-3 text-center">OTP ของคุณ</h2>

        <div id="otpCode" class="text-center text-3xl font-bold tracking-widest text-indigo-600 mb-4">
            ------
        </div>

        <p class="text-center text-sm text-gray-500 mb-3">
            หมดอายุใน 
            <span id="otpTimer" class="font-bold text-red-500"></span>
        </p>

        <button onclick="closeOtp()" class="mt-3 w-full text-gray-500 text-sm">
            ปิด
        </button>
    </div>
</div>
<script>
let timerInterval;

function startTimer(expireTimeStr){
    clearInterval(timerInterval);

    const expireTime = new Date(expireTimeStr).getTime();

    timerInterval = setInterval(()=>{
        const now = new Date().getTime();
        const diff = expireTime - now;

        if(diff <= 0){
            clearInterval(timerInterval);

            // 🔥 หมดเวลา → ขอ OTP ใหม่
            refreshOTP();
            return;
        }

        const min = Math.floor(diff / 60000);
        const sec = Math.floor((diff % 60000) / 1000);

        document.getElementById("otpTimer").innerHTML = min + "m " + sec + "s";

    },1000);
}

function refreshOTP(){
    const eid = currentEventId;

    fetch('create-otp-ajax?eid=' + eid)
    .then(res => {
        if (!res.ok) {
            throw new Error('Network response was not ok');
        }
        return res.json();
    })
    .then(data => {
        if (data.error) {
            alert('Error: ' + data.error);
            return;
        }
        document.getElementById('otpCode').innerText = data.otp;
        startTimer(data.expire);
    })
    .catch(error => {
        console.error('Error refreshing OTP:', error);
        alert('Failed to refresh OTP. Please try again.');
    });
}

function closeOtp(){
    const modal = document.getElementById('otpModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}
</script>