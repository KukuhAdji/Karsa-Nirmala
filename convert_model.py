import tensorflow as tf

SOURCE_MODEL = "FastAPI/models/wise_mobilenetv2_final_rebuilt.keras"
OUTPUT_MODEL = "FastAPI/models/wise_mobilenetv2_final_rebuilt.h5"

print("TensorFlow:", tf.__version__)

print("Loading original model...")
model = tf.keras.models.load_model(
    SOURCE_MODEL,
    compile=False
)

print("Original model loaded successfully.")
print("Input shape :", model.input_shape)
print("Output shape:", model.output_shape)

print("Saving as legacy HDF5...")
model.save(
    OUTPUT_MODEL,
    include_optimizer=False,
    save_format="h5"
)

print("Testing HDF5 model...")

test_model = tf.keras.models.load_model(
    OUTPUT_MODEL,
    compile=False
)

print("HDF5 MODEL LOADED SUCCESSFULLY")
print("Input shape :", test_model.input_shape)
print("Output shape:", test_model.output_shape)