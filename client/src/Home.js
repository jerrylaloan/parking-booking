import React, { useState, useEffect } from 'react';
import {
  Button,
  Heading,
  Image,
  Stack,
  Text,
  Box,
  Center,
  useColorModeValue,
  Badge,
  VStack,
} from '@chakra-ui/react';
import { useNavigate } from 'react-router';
import axios from 'axios';

export default function Home() {
  const [bays, setBays] = useState([]);

  useEffect(() => {
    if (bays.length === 0) {
      (async function () {
        const result = await axios.get(`http://localhost:8080/api/bays`);
        setBays(result.data);
      })();
    }
  }, [bays.length]);

  return (
    <Box py={12}>
      <VStack spacing={2} textAlign="center">
        <Heading as="h1" fontSize="4xl">
          Choose your bay
        </Heading>
        <Text fontSize="lg" color={'gray.500'}>
          Easy & simple parking booking
        </Text>
      </VStack>
      <Center>
        <Stack spacing={10} direction="row" align="center">
          {bays.length &&
            bays.map(({ id, name, location, available }) => {
              console.log('coba renderl');
              return (
                <Bay
                  id={id}
                  name={name}
                  location={location}
                  available={available}
                />
              );
            })}
        </Stack>
      </Center>
    </Box>
  );
}

const IMAGE = 'https://source.unsplash.com/oYbuLwFpxqk';

function Bay({ id, name = '', location = '', available = true }) {
  const navigate = useNavigate();

  const redirectToBooking = () => {
    console.log('my bay >>> ', id);
    navigate(`/booking-form/${id}`, { replace: true });
  };

  return (
    <Center py={12}>
      <Box
        role={'group'}
        p={6}
        maxW={'330px'}
        w={'full'}
        bg={useColorModeValue('white', 'gray.800')}
        boxShadow={'2xl'}
        rounded={'lg'}
        pos={'relative'}
        zIndex={1}
      >
        <Box
          rounded={'lg'}
          mt={-12}
          pos={'relative'}
          height={'230px'}
          _after={{
            transition: 'all .3s ease',
            content: '""',
            w: 'full',
            h: 'full',
            pos: 'absolute',
            top: 5,
            left: 0,
            backgroundImage: `url(${IMAGE})`,
            filter: 'blur(15px)',
            zIndex: -1,
          }}
          _groupHover={{
            _after: {
              filter: 'blur(20px)',
            },
          }}
        >
          <Image
            rounded={'lg'}
            height={230}
            width={282}
            objectFit={'cover'}
            src={IMAGE}
          />
        </Box>
        <Stack pt={10} align={'center'}>
          <Text color={'gray.500'} fontSize={'sm'} textTransform={'uppercase'}>
            {name}
          </Text>
          <Heading fontSize={'2xl'} fontFamily={'body'} fontWeight={500}>
            {location}
          </Heading>
          <Badge colorScheme={!available ? 'red' : 'green'}>
            {!available ? 'not available' : 'available'}
          </Badge>
        </Stack>
        <Button
          disabled={available ? false : true}
          w={'full'}
          mt={8}
          bg={useColorModeValue('#151f21', 'gray.900')}
          color={'white'}
          rounded={'md'}
          _hover={{
            transform: 'translateY(-2px)',
            boxShadow: 'lg',
          }}
          onClick={redirectToBooking}
        >
          Book
        </Button>
      </Box>
    </Center>
  );
}
