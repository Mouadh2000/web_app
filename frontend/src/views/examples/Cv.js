import React, { useState, useEffect } from 'react';
import Swal from 'sweetalert2';
import "assets/css/sweetAlertStyle.css";
import {
    Badge,
    Card,
    CardHeader,
    CardFooter,
    Col,
    Button,
    Media,
    Pagination,
    PaginationItem,
    PaginationLink,
    Table,
    Container,
    Row,
    UncontrolledTooltip,
} from "reactstrap";
import Header from "components/Headers/Header.js";
import { useAuth } from "context/AuthContext";
import axiosInstance from "axiosApi";

const Cv = () => {
    const { currentUser } = useAuth();
    const [file, setFile] = useState(null);
    const [fileName, setFileName] = useState('');
    const [cvs, setCvs] = useState([]);
    const [loading, setLoading] = useState(false);
    console.log(currentUser.id);

    useEffect(() => {
        fetchCvs();
    }, []);

    const fetchCvs = async () => {
        setLoading(true);
        try {
            const response = await axiosInstance.get('/getAllCvs/');
            setCvs(response.data);
            setLoading(false);
        } catch (error) {
            console.error('Error fetching CVs:', error);
            setLoading(false);
            // Handle error appropriately
        }
    };

    const handleFileChange = (e) => {
        const selectedFile = e.target.files[0];
        setFile(selectedFile);
        setFileName(selectedFile ? selectedFile.name : '');
    };

    const handleFileUpload = async () => {
        try {
            const formData = new FormData();
            formData.append('file', file);
            formData.append('user_id', currentUser.id);

            const response = await axiosInstance.post('/upload/', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                },
            });

            console.log('File uploaded successfully:', response.data);
            Swal.fire({
                icon: 'success',
                title: 'File Uploaded!',
                text: 'Your file has been uploaded successfully.',
            });
            fetchCvs(); // Refresh CV list after successful upload
        } catch (error) {
            console.error('Error uploading file:', error);
            // Handle error appropriately
        }
    };

    const triggerFileInput = () => {
        document.getElementById('fileInput').click();
    };

    const handleFileDownload = async (filename) => {
        try {
            const response = await axiosInstance.post('/download/', { filename }, {
                responseType: 'blob', // Important to handle the file as a Blob
            });

            const url = window.URL.createObjectURL(new Blob([response.data]));
            const link = document.createElement('a');
            link.href = url;
            link.setAttribute('download', filename);
            document.body.appendChild(link);
            link.click();
            link.parentNode.removeChild(link);
        } catch (error) {
            console.error('Error downloading file:', error);
            // Handle error appropriately
        }
    };

    return (
        <>
            <Header />
            <Container className="mt--7" fluid>
                <Row>
                    <div className="col">
                        <Card className="shadow">
                            <CardHeader className="border-0">
                                <Row className="align-items-center">
                                    <Col xs="8">
                                        <h3 className="mb-0">Cvs</h3>
                                    </Col>
                                    <Col className="text-right" xs="12">
                                        <Button color="primary" onClick={triggerFileInput}>
                                            Import CV
                                        </Button>
                                        <input
                                            id="fileInput"
                                            type="file"
                                            accept=".pdf"
                                            style={{ display: 'none' }}
                                            onChange={handleFileChange}
                                        />
                                        {fileName && <span className="ml-3">{fileName}</span>}
                                        <Button color="primary" onClick={handleFileUpload} className="ml-3">
                                            Upload
                                        </Button>
                                    </Col>
                                </Row>
                            </CardHeader>
                            <Table className="align-items-center table-flush" responsive>
                                <thead className="thead-light">
                                    <tr>
                                        <th scope="col">First Name</th>
                                        <th scope="col">Last Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">CV</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {loading ? (
                                        <tr><td colSpan="4">Loading...</td></tr>
                                    ) : (
                                        cvs.map((cv, index) => (
                                            <tr key={index}>
                                                <td>{cv.first_name}</td>
                                                <td>{cv.last_name}</td>
                                                <td>{cv.email}</td>
                                                <td>
                                                    <Button
                                                        color="primary"
                                                        size="sm"
                                                        onClick={() => handleFileDownload(cv.file)}
                                                    >
                                                        Download
                                                    </Button>
                                                </td>
                                            </tr>
                                        ))
                                    )}
                                </tbody>
                            </Table>
                            <CardFooter className="py-4">
                                <nav aria-label="...">
                                    <Pagination
                                        className="pagination justify-content-end mb-0"
                                        listClassName="justify-content-end mb-0"
                                    >
                                        <PaginationItem className="disabled">
                                            <PaginationLink
                                                href="#pablo"
                                                onClick={(e) => e.preventDefault()}
                                                tabIndex="-1"
                                            >
                                                <i className="fas fa-angle-left" />
                                                <span className="sr-only">Previous</span>
                                            </PaginationLink>
                                        </PaginationItem>
                                        <PaginationItem className="active">
                                            <PaginationLink
                                                href="#pablo"
                                                onClick={(e) => e.preventDefault()}
                                            >
                                                1
                                            </PaginationLink>
                                        </PaginationItem>
                                        <PaginationItem>
                                            <PaginationLink
                                                href="#pablo"
                                                onClick={(e) => e.preventDefault()}
                                            >
                                                2 <span className="sr-only">(current)</span>
                                            </PaginationLink>
                                        </PaginationItem>
                                        <PaginationItem>
                                            <PaginationLink
                                                href="#pablo"
                                                onClick={(e) => e.preventDefault()}
                                            >
                                                3
                                            </PaginationLink>
                                        </PaginationItem>
                                        <PaginationItem>
                                            <PaginationLink
                                                href="#pablo"
                                                onClick={(e) => e.preventDefault()}
                                            >
                                                <i className="fas fa-angle-right" />
                                                <span className="sr-only">Next</span>
                                            </PaginationLink>
                                        </PaginationItem>
                                    </Pagination>
                                </nav>
                            </CardFooter>
                        </Card>
                    </div>
                </Row>
            </Container>
        </>
    );
};

export default Cv;
