<!-- 🔥 EDIT MODAL -->
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white w-full max-w-lg max-h-[90vh] rounded-xl shadow-lg p-6 relative flex flex-col">
        
        <h2 class="text-2xl font-bold mb-4 text-gray-800 flex-shrink-0">แก้ไขกิจกรรม</h2>

        <div class="overflow-y-auto flex-1 pr-2">
            <form method="POST" action="edit-event" enctype="multipart/form-data">
                <input type="hidden" name="event_id" id="edit_id">

                <label class="block mb-2 text-sm font-medium">ชื่อกิจกรรม</label>
                <input type="text" name="name" id="edit_name" class="w-full border rounded-lg p-2 mb-3" required>

                <label class="block mb-2 text-sm font-medium">รายละเอียด</label>
                <textarea name="description" id="edit_description" class="w-full border rounded-lg p-2 mb-3" required></textarea>

                <label class="block mb-2 text-sm font-medium">วันที่</label>
                <input type="date" name="date" id="edit_date" class="w-full border rounded-lg p-2 mb-3" required>

                <label class="block mb-2 text-sm font-medium">จำนวนคน</label>
                <input type="number" name="max" id="edit_max" class="w-full border rounded-lg p-2 mb-3" required>

                <label class="block mb-2 text-sm font-medium">รูปภาพกิจกรรม</label>
                <div class="mb-3">
                    <!-- Current Images Display -->
                    <div id="current_images_container" class="mb-3 hidden">
                        <p class="text-xs text-gray-600 mb-2">รูปภาพปัจจุบัน (กด X เพื่อลบ):</p>
                        <div id="images_grid" class="grid grid-cols-3 gap-2">
                            <!-- Images will be inserted here dynamically -->
                        </div>
                        <input type="hidden" name="remove_images" id="remove_images" value="">
                    </div>
                
                <!-- New Image Upload -->
                <input type="file" name="image" id="edit_image" accept="image/*" class="w-full border rounded-lg p-2">
                <p class="text-xs text-gray-500 mt-1">เลือกรูปภาพใหม่ (ถ้าต้องการเปลี่ยน) - รองรับ .jpg, .png, .gif</p>
            </div>

            <div class="flex justify-end gap-2 mt-4 flex-shrink-0 pt-2">
                <button type="button" onclick="closeModal()" class="px-4 py-2 bg-gray-300 rounded-lg flex-shrink-0">
                    ยกเลิก
                </button>
                <button onclick="return confirm('คุณจะบันทึกใช่มั้ย?')" type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg flex-shrink-0">
                    บันทึก
                </button>
            </div>
        </form>

        <!-- ปุ่มปิด -->
        <button onclick="closeModal()" class="absolute top-2 right-3 text-xl flex-shrink-0">&times;</button>
    </div>
</div>

<script>
// Store current images and removed images
let currentImages = [];
let removedImages = [];

// Function to show all current images when opening modal
function showCurrentImages(imagesString) {
    console.log('Images string received:', imagesString);
    
    const container = document.getElementById('current_images_container');
    const grid = document.getElementById('images_grid');
    
    // Reset arrays
    currentImages = [];
    removedImages = [];
    document.getElementById('remove_images').value = '';
    
    if (imagesString && imagesString !== '') {
        currentImages = imagesString.split(',').filter(img => img.trim() !== '');
        console.log('Parsed images:', currentImages);
        
        if (currentImages.length > 0) {
            renderImages();
            container.classList.remove('hidden');
        } else {
            container.classList.add('hidden');
        }
    } else {
        console.log('No images to display');
        container.classList.add('hidden');
    }
}

// Function to render all images in grid
function renderImages() {
    const grid = document.getElementById('images_grid');
    grid.innerHTML = '';
    
    currentImages.forEach((img, index) => {
        if (!removedImages.includes(img)) {
            const imgDiv = document.createElement('div');
            imgDiv.className = 'relative';
            imgDiv.innerHTML = `
                <img src="uploads/${img.trim()}" alt="Event image" class="w-full h-24 object-cover rounded-lg border">
                <button type="button" onclick="removeImage('${img.trim()}')" 
                        class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-600 transition shadow-md">
                    <i class="fas fa-times text-xs"></i>
                </button>
            `;
            grid.appendChild(imgDiv);
        }
    });
    
    // Update hidden input with removed images
    document.getElementById('remove_images').value = removedImages.join(',');
    
    // Hide container if all images removed
    if (removedImages.length === currentImages.length) {
        document.getElementById('current_images_container').classList.add('hidden');
    }
}

// Function to remove specific image
function removeImage(imageName) {
    if (!removedImages.includes(imageName)) {
        removedImages.push(imageName);
        renderImages();
    }
}

// Function to reset image fields when closing modal
function closeModal() {
    const modal = document.getElementById('editModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    
    // Reset image fields
    currentImages = [];
    removedImages = [];
    document.getElementById('remove_images').value = '';
    document.getElementById('edit_image').value = '';
    document.getElementById('images_grid').innerHTML = '';
    document.getElementById('current_images_container').classList.add('hidden');
}

// Backward compatibility - keep old function name
function showCurrentImage(imageSrc) {
    showCurrentImages(imageSrc);
}
</script>