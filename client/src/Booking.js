import React, { useState } from 'react';
import {
  Box,
  Button,
  FormControl,
  Flex,
  Heading,
  Input,
  Stack,
  Text,
  useColorModeValue,
  VStack,
  Center,
  Modal,
  ModalOverlay,
  ModalContent,
  ModalBody,
  Icon,
  Link,
} from '@chakra-ui/react';
import { useParams, useNavigate, Navigate } from 'react-router';
import { AiOutlineBarcode } from 'react-icons/ai';
import axios from 'axios';

export default function Booking() {
  const { bayId } = useParams();

  return (
    <>
      {!bayId && <Navigate to="/" replace={true} />}
      <Box py={12}>
        <VStack spacing={2} textAlign="center">
          <Heading as="h1" fontSize="4xl">
            Booking form
          </Heading>
        </VStack>
        <Center>
          <Form bayId={bayId} />
        </Center>
      </Box>
    </>
  );
}
function Form({ bayId = 0 }) {
  const navigate = useNavigate();

  const [showModal, setShowModal] = useState(false);

  const redirectToHome = () => {
    navigate('/', { replace: true });
  };

  const [formData, setFormData] = useState({
    bay_id: bayId,
    renter: '',
  });




  const [newBookingCode, setNewBookingCode] = useState('')
  const onSubmit = async () => {
    const result = await axios.post('http://localhost:8080/api/booking', {
      bay_id: formData.bay_id,
      renter: formData.renter,
    });
    
    const { data } = result
    setNewBookingCode(data.code);
    setShowModal(true);
  };

  const onInput = e => {
    const renter = e.target.value;
    console.log('renter >>> ', renter);
    setFormData({
      bay_id: formData.bay_id,
      renter,
    });
  };

  return (
    <>
      <Flex align={'center'} justify={'center'}>
        <Stack
          spacing={4}
          w={'full'}
          maxW={'md'}
          bg={useColorModeValue('white', 'gray.700')}
          rounded={'xl'}
          boxShadow={'lg'}
          p={6}
          my={12}
        >
          <Heading lineHeight={1.1} fontSize={{ base: '2xl', md: '3xl' }}>
            Name for the booking
          </Heading>
          <FormControl id="name">
            <Input
              placeholder="John Doe"
              _placeholder={{ color: 'gray.500' }}
              type="text"
              onInput={onInput}
            />
          </FormControl>
          <Stack spacing={6}>
            <Button
              disabled={formData.bay_id === 0}
              bg={'black'}
              color={'white'}
              _hover={{
                bg: 'blak',
              }}
              onClick={onSubmit}
            >
              Submit Booking
            </Button>
          </Stack>
        </Stack>
      </Flex>
      {/* modal success */}
      <Modal onClose={() => {}} isOpen={showModal} isCentered>
        <ModalOverlay />
        <ModalContent>
          <ModalBody>
            <Box textAlign="center" py={10} px={6}>
              <Icon as={AiOutlineBarcode} boxSize={'70px'} />
              <Heading as="h2" size="xl" mt={6} mb={2}>
                Booking Success!
                <br />
                code: {newBookingCode}
              </Heading>
              <Text color={'gray.500'}>Please save your booking code</Text>
              <Text color={'gray.500'}>
                Click{' '}
                <Link onClick={redirectToHome} color={'blue.500'}>
                  here
                </Link>{' '}
                to redirect
              </Text>
            </Box>
          </ModalBody>
        </ModalContent>
      </Modal>
    </>
  );
}
