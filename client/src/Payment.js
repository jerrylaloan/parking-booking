import React, { useState } from 'react';
import {
  Link,
  Kbd,
  Box,
  Button,
  FormControl,
  FormLabel,
  Flex,
  Heading,
  Spacer,
  Input,
  Stack,
  Text,
  useColorModeValue,
  VStack,
  Center,
  InputGroup,
  InputLeftElement,
  Icon,
  Popover,
  PopoverTrigger,
  PopoverContent,
  PopoverArrow,
  PopoverBody,
  Modal,
  ModalOverlay,
  ModalContent,
  ModalCloseButton,
  ModalHeader,
  ModalBody,
  ModalFooter,
} from '@chakra-ui/react';
import { useParams, useNavigate, Navigate } from 'react-router';
import {
  InfoOutlineIcon,
  TimeIcon,
  CheckCircleIcon,
  WarningIcon,
} from '@chakra-ui/icons';
import { MdAttachMoney } from 'react-icons/md';
import { AiOutlineBarcode } from 'react-icons/ai';
import { IoMdText } from 'react-icons/io';
import { GiPartyPopper } from 'react-icons/gi';
import axios from 'axios';

export default function Payment() {
  const navigate = useNavigate();

  const [formData, setFormData] = useState(null);
  const [showModal, setShowModal] = useState(false);
  const [showErrorModal, setShowErrorModal] = useState(false);

  const handleSubmit = async () => {
    await axios.post('http://localhost:8080/api/payment', {
      bay_id: formData.bay_id,
      code: formData.code,
    });
    setShowModal(true);
  };

  const redirectToHome = () => {
    navigate('/', { replace: true });
  };

  const searchBookingCode = async e => {
    if (e.key === 'Enter') {
      console.log('enter press here! ');
      try {
        const result = await axios.get(
          `http://localhost:8080/api/booking/${formData.code}`
        );

        const { data } = result;

        console.log('result >>> ', result.data);
        console.log(formData);
        setFormData({
          bay_id: data.bay_id,
          code: formData.code,
          renter: data.renter,
          duration: data.hours,
          amount: data.price,
        });
      } catch (error) {
        setShowErrorModal(true);
      }
    }
  };

  const onInputCode = e => {
    const code = e.target.value;
    setFormData({
      code,
    });
  };

  return (
    <>
      <Box py={12}>
        <VStack spacing={2} textAlign="center">
          <Heading as="h1" fontSize="4xl">
            Check your booking!
          </Heading>
        </VStack>
        <Center>
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
                Booking details
              </Heading>
              <FormControl id="code">
                <Flex alignItems="center">
                  <Box mr={3}>
                    <InputGroup>
                      <InputLeftElement
                        pointerEvents="none"
                        children={
                          <Icon as={AiOutlineBarcode} color="gray.500" />
                        }
                      />
                      <Input
                        placeholder="Code. ex: XYZ00"
                        _placeholder={{ color: 'gray.500' }}
                        type="text"
                        value={formData?.code || ''}
                        onInput={onInputCode}
                        onKeyDown={searchBookingCode}
                      />
                    </InputGroup>
                  </Box>
                  <Box>
                    <Popover trigger="hover" variant="responsive">
                      <PopoverTrigger>
                        <InfoOutlineIcon />
                      </PopoverTrigger>
                      <PopoverContent>
                        <PopoverArrow />
                        <PopoverBody>
                          Enter booking code + <Kbd>Enter</Kbd>
                        </PopoverBody>
                      </PopoverContent>
                    </Popover>
                  </Box>
                </Flex>
              </FormControl>
              <FormControl id="renter">
                <InputGroup>
                  <InputLeftElement
                    pointerEvents="none"
                    children={<Icon as={IoMdText} color="gray.500" />}
                  />
                  <Input
                    disabled
                    placeholder="Name"
                    _placeholder={{ color: 'gray.500' }}
                    type="text"
                    value={formData?.renter || ''}
                  />
                </InputGroup>
              </FormControl>
              <FormControl id="duration">
                <InputGroup>
                  <InputLeftElement
                    pointerEvents="none"
                    children={<TimeIcon color="gray.500" />}
                  />
                  <Input
                    disabled
                    placeholder="Duration"
                    _placeholder={{ color: 'gray.500' }}
                    type="text"
                    value={formData?.duration || ''}
                  />
                </InputGroup>
              </FormControl>
              <FormControl id="price">
                <InputGroup>
                  <InputLeftElement
                    pointerEvents="none"
                    children={<Icon as={MdAttachMoney} color="gray.500" />}
                  />
                  <Input
                    disabled
                    placeholder="Amount to Pay"
                    _placeholder={{ color: 'gray.500' }}
                    type="text"
                    value={formData === null ? 0 : formData.amount}
                  />
                </InputGroup>
              </FormControl>
              <Stack spacing={6}>
                <Button
                  bg={'black'}
                  color={'white'}
                  _hover={{
                    bg: 'blak',
                  }}
                  onClick={handleSubmit}
                >
                  Submit
                </Button>
              </Stack>
            </Stack>
          </Flex>
        </Center>
      </Box>

      {/* modal success */}
      <Modal onClose={() => {}} isOpen={showModal} isCentered>
        <ModalOverlay />
        <ModalContent>
          <ModalBody>
            <Box textAlign="center" py={10} px={6}>
              {/* <CheckCircleIcon boxSize={'50px'} color={'green.500'} /> */}
              <Icon as={GiPartyPopper} boxSize={'70px'} />
              <Heading as="h2" size="xl" mt={6} mb={2}>
                Payment Success!
              </Heading>
              <Text color={'gray.500'}>
                Thankyou for your payment :)
                <br /> Click{' '}
                <Link onClick={redirectToHome} color={'blue.500'}>
                  here
                </Link>{' '}
                to redirect
              </Text>
            </Box>
          </ModalBody>
        </ModalContent>
      </Modal>

      {/* modal failed */}
      <Modal
        onClose={() => setShowErrorModal(false)}
        isOpen={showErrorModal}
        isCentered
      >
        <ModalOverlay />
        <ModalContent>
          <ModalCloseButton />
          <ModalBody>
            <Box textAlign="center" py={10} px={6}>
              <WarningIcon boxSize={'50px'} color={'red.500'} />
              <Heading as="h2" size="xl" mt={6} mb={2}>
                An error occured
              </Heading>
              <Text color={'gray.500'}>Please try again!</Text>
            </Box>
          </ModalBody>
        </ModalContent>
      </Modal>
    </>
  );
}
