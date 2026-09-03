import TextInput from "@/Components/Form/TextInput";
import Type from "lucide-react/dist/esm/icons/type.js";

const RedirectionFrom = ({
    data,
    errors,
    processing,
    onDataChange,
    children,
    progress,
}) => {
    return (
        <>
            <div className="row">
                {/* old Url */}
                <div className="mb-3 col-md-6">
                    <TextInput
                        name="old_url"
                        label="Old URL"
                        value={data.old_url}
                        onChange={(value) => onDataChange("old_url", value)}
                        error={errors.old_url}
                        placeholder="https://example.com/old-page"
                        required={true}
                        disabled={processing}
                        icon={<Type size={16} />}
                    />
                    {errors.old_url && (
                        <div className="text-danger small">
                            {errors.old_url}
                        </div>
                    )}
                </div>

                {/* New URL */}
                <div className="mb-3 col-md-6">
                    <TextInput
                        name="new_url"
                        label="New URL"
                        value={data.new_url}
                        onChange={(value) => onDataChange("new_url", value)}
                        error={errors.new_url}
                        placeholder="https://example.com/new-page"
                        required={true}
                        disabled={processing}
                        icon={<Type size={16} />}
                    />
                    {errors.new_url && (
                        <div className="text-danger small">
                            {errors.new_url}
                        </div>
                    )}
                </div>

                <div className="mb-3 col-md-6">
                    <label className="form-label">Status *</label>
                    <select
                        className="form-select"
                        value={data.status}
                        onChange={(e) => onDataChange("status", e.target.value)}
                    >
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                    {errors.status && (
                        <div className="text-danger small">{errors.status}</div>
                    )}
                </div>
            </div>

            {/* Progress Bar */}
            {progress && (
                <div className="progress mt-2">
                    <div
                        className="progress-bar"
                        role="progressbar"
                        style={{ width: `${progress.percentage}%` }}
                        aria-valuenow={progress.percentage}
                        aria-valuemin="0"
                        aria-valuemax="100"
                    >
                        {progress.percentage}%
                    </div>
                </div>
            )}

            {children}
        </>
    );
};

export default RedirectionFrom;
