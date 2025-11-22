import { editProfile } from "./editProfile.js";
import { changePassword } from "./changePassword.js";

document.addEventListener('DOMContentLoaded', (e) => {
	editProfile(document);
	changePassword(document);
})