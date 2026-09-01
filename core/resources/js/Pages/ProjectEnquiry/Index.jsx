import React, { useRef, useState } from 'react';
import { ToastContainer } from 'react-toastify';
import { useFlashMessage } from '@/hooks/useFlashMessage';
import { useDeleteConfirmation } from '@/hooks/useDeleteConfirmation';
import DeleteConfirmationModal from '@/Components/DeleteConfirmationModal';
import Pagination from '@/Components/Pagination';
import TableHeader from '@/Components/TableHeader';
import { useDebouncedSearch } from '@/hooks/useSearch';

const valueOrDash = (value) => value || <span className="text-muted">—</span>;

const Detail = ({ label, value, children }) => (
    <div className="mb-3">
        <label className="form-label fw-semibold text-muted small">{label}</label>
        <div className="border rounded p-3 bg-light">{children || <span className="fw-medium">{valueOrDash(value)}</span>}</div>
    </div>
);

const Index = ({ searchTerm, projectEnquiries }) => {
    const [query, setQuery] = useState(searchTerm || '');
    const [selected, setSelected] = useState(null);
    const modalRef = useRef(null);
    const modalInstance = useRef(null);
    useDebouncedSearch(query, 'project-enquiries');
    useFlashMessage();

    const showDetails = (item) => {
        setSelected(item);
        setTimeout(() => {
            if (modalRef.current) {
                modalInstance.current = new window.bootstrap.Modal(modalRef.current);
                modalInstance.current.show();
            }
        }, 0);
    };

    const closeDetails = () => {
        modalInstance.current?.hide();
        setSelected(null);
    };

    const deletion = useDeleteConfirmation('project-enquiries.destroy');

    return (
        <>
            <h1 className="text-muted">Project Enquiries</h1>
            <ToastContainer />
            <div className="card">
                <TableHeader searchValue={query} onSearchChange={setQuery} searchPlaceholder="Search by name, company or email..." searchColClass="col-md-6 col-12" filterColClass="" buttonColClass="col-md-6 col-12" />
                <div className="table-responsive text-nowrap">
                    <table className="table table-hover my-table">
                        <thead><tr><th>Name</th><th>Company</th><th>Email</th><th>Requirement</th><th>Location</th><th>Actions</th></tr></thead>
                        <tbody>
                            {projectEnquiries.data.map((item) => (
                                <tr key={item.id}>
                                    <td>{item.full_name}</td>
                                    <td>{item.company_name}</td>
                                    <td><a href={`mailto:${item.business_email}`}>{item.business_email}</a></td>
                                    <td>{item.project_requirement}</td>
                                    <td>{item.project_location}</td>
                                    <td>
                                        <button type="button" className="btn btn-outline-primary btn-sm me-1" onClick={() => showDetails(item)}>View</button>
                                        <button type="button" className="btn btn-outline-danger btn-sm" onClick={() => deletion.confirmDelete(item.id, { name: item.full_name })}>Delete</button>
                                    </td>
                                </tr>
                            ))}
                            {projectEnquiries.data.length === 0 && <tr><td colSpan="6" className="text-center text-muted py-4">No project enquiries found.</td></tr>}
                        </tbody>
                    </table>
                </div>
            </div>

            <DeleteConfirmationModal modalRef={deletion.modalRef} title="Confirm Deletion" message="Are you sure you want to delete this project enquiry?" itemName={deletion.itemToDelete?.name} onConfirm={deletion.handleDelete} processing={deletion.processing} />

            <div className="modal fade modal-right" tabIndex="-1" aria-hidden="true" ref={modalRef}>
                <div className="modal-dialog modal-dialog-scrollable modal-lg"><div className="modal-content">
                    <div className="modal-header"><h5 className="modal-title">Project Enquiry Details</h5><button type="button" className="btn-close" onClick={closeDetails}></button></div>
                    {selected && <div className="modal-body">
                        <div className="row">
                            <div className="col-md-6"><Detail label="Full Name" value={selected.full_name} /><Detail label="Company Name" value={selected.company_name} /><Detail label="Business Email"><a href={`mailto:${selected.business_email}`}>{selected.business_email}</a></Detail><Detail label="Contact Number"><a href={`tel:${selected.contact_number}`}>{selected.contact_number}</a></Detail></div>
                            <div className="col-md-6"><Detail label="Project Requirement" value={selected.project_requirement} /><Detail label="Project Location" value={selected.project_location} /><Detail label="Submitted On" value={selected.created_at ? new Date(selected.created_at).toLocaleString() : null} /></div>
                            <div className="col-12"><Detail label="Message" value={selected.message} /></div>
                        </div>
                    </div>}
                    <div className="modal-footer"><button type="button" className="btn btn-secondary" onClick={closeDetails}>Close</button></div>
                </div></div>
            </div>

            {projectEnquiries.links.length > 3 && <div className="row m-2"><div className="col-md-4"><p className="text-dark mb-0 mt-2">Showing {projectEnquiries.from ?? 0} to {projectEnquiries.to ?? 0} of {projectEnquiries.total} entries</p></div><div className="col-md-8"><div className="float-end"><Pagination links={projectEnquiries.links} query={query} /></div></div></div>}
        </>
    );
};

export default Index;
