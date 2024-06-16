<template>
	<div class="content" id="image">
		<form>
			<div class="custom-box">
				<div class="box-body" :class="{'pointer-events': isLoading }">
					<h4 class="text-center text-bold" style="padding-bottom: 20px;">Image Upload - {{
                            product.name
                        }}</h4>

					<div class="col-md-12 mb-4">
						<model-select :options="color" v-model="selectedColor" placeholder="Select Color" />
					</div>

					<div class="col-md-12" id="image" style="margin-top: 20px" v-if="selectedColor !== ''">
						<div class="col-md-4">
							<vue-upload-multiple-image :browseText="'(Allowed File Types: jpg, png, gif)'" :dragText="'Drag file or Click here to Upload'" :markIsPrimaryText="''" :maxImage="200" :popupText="'This image will be displayed as default'" :primaryText="'Default'" :data-images="images" @upload-success="uploadImageSuccess" @edit-image="editImage" @before-remove="beforeRemove"></vue-upload-multiple-image>
						</div>
						<div class="col-md-8" v-if="cropShow">
							<form @submit.prevent="uploadCroppedImage()">
								<div class="modal-content">
									<div class="modal-header">
										<button @click="showCrop()" type="button" class="close" aria-label="Close">
											<span aria-hidden="true">×</span></button>
										<h4 class="modal-title">Crop Image</h4>
									</div>
									<div class="modal-body">
										<cropper :src="crop.path" :stencilProps="{
                                    aspectRatio: 10/12,
                                    minAspectRatio:3/4,
                                    maxAspectRatio:10/12,
                                    }" class="cropper" ref="main_cropper"></cropper>
									</div>
									<div class="modal-footer">
										<button type="submit" class="btn btn-success pull-left">Crop Image</button>
										<button type="button" @click="showCrop()" class="btn btn-danger">Cancel
										</button>
									</div>
								</div>
							</form>
						</div>
					</div>

					<div class="row col-md-12" style="margin-top: 10px">
						<div class="row col-md-12" v-for="chunk in chunkImages" style="display: flex;margin-bottom: 10px">
							<div @click="selectForCrop(image)" class="col-md-3 image-list" v-for="(image,index) in chunk">
								<img style="width: 100%" :src="image.path" alt="">
							</div>
						</div>

					</div>

				</div>

			</div>
		</form>
	</div>
</template>

<script>
import collect from "collect.js";
import VueUploadMultipleImage from "vue-upload-multiple-image";
import { Cropper } from "vue-advanced-cropper";
import "vue-advanced-cropper/dist/style.css";

export default {
	name: "ProductImageUpload",
	props: ["product-info", "product-options", "product-options-values"],
	components: {
		VueUploadMultipleImage,
		Cropper,
	},
	data() {
		return {
			product: { ...this.productInfo },
			variationOptions: [this.productOptions],
			variationValues: [...this.productOptionsValues],
			color: [],
			images: [],
			cropShow: false,
			crop: [],
			selectedColor: "",
		};
	},
	methods: {
		showCrop() {
			this.cropShow = !this.cropShow;
		},
		getImages() {
			this.Loader(true);
			axios
				.get(
					route("product-image.index") +
						"?product-id=" +
						this.product.id
				)
				.then((response) => {
					this.images = response.data.result;
					this.Loader(false);
				})
				.catch((error) => {
					//this.Loader();
				});
		},
		uploadImageSuccess(formData, index, fileList) {
			formData.append("product_id", this.product.id);
			formData.append("product_barcode", this.product.product_code);
			formData.append("variation_id", this.selectedColor);
			this.Loader(true);
			axios
				.post(route("product-image.store"), formData)
				.then((response) => {
					toastr.success("Image upload successfully");
					this.selectedColor = "";
					this.getImages();
				})
				.catch((error) => {
					//this.Loader();
				});
		},
		editImage(formData, index, fileList) {
			let current_file = fileList[index];
			formData.append("id", current_file.id);
			formData.append("product_id", current_file.product_id);
			formData.append("product_barcode", current_file.product_barcode);
			this.Loader(true);
			axios
				.post(route("product-image.update"), formData)
				.then((response) => {
					this.getImages();
					toastr.success("Image update successfully");
				})
				.catch((error) => {
					//this.Loader();
				});
		},
		beforeRemove(index, done, fileList) {
			this.Loader(true);
			axios
				.delete(route("product-image.destroy") + fileList[index].id)
				.then((response) => {
					this.images = response.data.result;
					toastr.success("Image delete successfully");
					this.getImages();
				})
				.catch((error) => {
					//this.Loader();
				});
		},
		selectForCrop: function (source) {
			this.crop = source;
			this.cropShow = true;
			window.scrollTo({ top: 70, left: 0, behavior: "smooth" });
		},
		uploadCroppedImage: function () {
			const _this = this;
			const { canvas } = this.$refs.main_cropper.getResult();
			if (canvas) {
				const formData = new FormData();
				formData.append("id", this.crop.id);
				formData.append("product_id", this.crop.product_id);
				formData.append("product_barcode", this.crop.product_barcode);
				this.Loader(true);
				canvas.toBlob((blob) => {
					formData.append("cropped_image", blob);
					axios
						.post(route("product-image.crop"), formData)
						.then((response) => {
							this.getImages();
							this.showCrop();
							toastr.success("Image cropped successfully");
						})
						.catch((error) => {
							this.Loader(false);
							toastr.error("Something went wrong");
						});
				}, "image/webp/png/jpeg");
			} else {
				toastr.error("Something went wrong");
			}
		},
		setColour() {
			this.color = collect(this.variationOptions)
				.map((option) => {
					return option.optionValues.map((item) => {
						return {
							value: item.value,
							text: item.text,
						};
					});
				})
				.collapse()
				.toArray();
		},
	},
	created() {
		this.getImages();
		this.setColour();
	},
	computed: {
		chunkImages() {
			return collect(this.images).chunk(4).all();
		},
	},
};
</script>

<style scoped>
</style>
