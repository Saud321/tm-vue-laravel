import {email as emailValidator, helpers, minLength, required} from "@vuelidate/validators";

export const loginValidationRules = {
    email: {
        required: helpers.withMessage("Email is required", required),
        email: helpers.withMessage("Must be a valid email", emailValidator),
    },
    password: {
        required: helpers.withMessage("Password is required", required),
        minLength: helpers.withMessage("Password must be at least 8 characters", minLength(8)),
    },
};
