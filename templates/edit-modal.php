<!-- 🔥 EDIT MODAL -->
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white w-full max-w-lg rounded-xl shadow-lg p-6 relative">
        
        <h2 class="text-2xl font-bold mb-4 text-gray-800">แก้ไขกิจกรรม</h2>

        <form method="POST" action="edit-event">
            <input type="hidden" name="event_id" id="edit_id">

            <label class="block mb-2 text-sm font-medium">ชื่อกิจกรรม</label>
            <input type="text" name="name" id="edit_name" class="w-full border rounded-lg p-2 mb-3" required>

            <label class="block mb-2 text-sm font-medium">รายละเอียด</label>
            <textarea name="description" id="edit_description" class="w-full border rounded-lg p-2 mb-3" required></textarea>

            <label class="block mb-2 text-sm font-medium">วันที่</label>
            <input type="date" name="date" id="edit_date" class="w-full border rounded-lg p-2 mb-3" required>

            <label class="block mb-2 text-sm font-medium">จำนวนคน</label>
            <input type="number" name="max" id="edit_max" class="w-full border rounded-lg p-2 mb-3" required>

            <div class="flex justify-end gap-2 mt-4">
                <button type="button" onclick="closeModal()" class="px-4 py-2 bg-gray-300 rounded-lg">
                    ยกเลิก
                </button>
                <button onclick="return confirm('คุณจะบันทึกใช่มั้ย?')" type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg">
                    บันทึก
                </button>
            </div>
        </form>

        <!-- ปุ่มปิด -->
        <button onclick="closeModal()" class="absolute top-2 right-3 text-xl">&times;</button>
    </div>
</div>