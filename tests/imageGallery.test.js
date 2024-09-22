const fetchMock = require('jest-fetch-mock');
fetchMock.enableMocks();

beforeEach(() => {
  // Reset mocks before each test
  fetchMock.resetMocks();

  // Setup a mock DOM for the tests
  document.body.innerHTML = `
    <div id="user-images" class="image-gallery"></div>
    <div id="other-users-images" class="image-gallery"></div>
    <div id="latest-images" class="image-gallery"></div>
  `;
});

describe('Image Gallery Fetch Tests', () => {
  test('should fetch and display user images', async () => {
    // Mock the response for user images
    fetchMock.mockResponseOnce(JSON.stringify([
      { file_path: 'user_image1.jpg' },
      { file_path: 'user_image2.jpg' }
    ]));

    const response = await fetch('/user/images');
    const images = await response.json();

    // Simulate adding images to the DOM
    const userImagesDiv = document.getElementById('user-images');
    images.forEach(image => {
      const imgElement = document.createElement('img');
      imgElement.src = `/storage/${image.file_path}`;
      userImagesDiv.appendChild(imgElement);
    });

    expect(fetch).toHaveBeenCalledWith('/user/images');
    expect(images.length).toBe(2);

    // Check if the images were added to the DOM
    expect(userImagesDiv.children.length).toBe(2);
    expect(userImagesDiv.children[0].src).toContain('user_image1.jpg');
  });

  test('should handle fetch error gracefully for user images', async () => {
    // Simulate a fetch error
    fetchMock.mockRejectOnce(new Error('Failed to fetch'));

    try {
      await fetch('/user/images');
    } catch (error) {
      // Ensure that the error is caught
      expect(error.message).toBe('Failed to fetch');
    }

    // Ensure that no images are added to the DOM
    const userImagesDiv = document.getElementById('user-images');
    expect(userImagesDiv.children.length).toBe(0);
  });

  test('should not display images when API returns empty array for user images', async () => {
    // Mock empty response
    fetchMock.mockResponseOnce(JSON.stringify([]));

    const response = await fetch('/user/images');
    const images = await response.json();

    const userImagesDiv = document.getElementById('user-images');
    images.forEach(image => {
      const imgElement = document.createElement('img');
      imgElement.src = `/storage/${image.file_path}`;
      userImagesDiv.appendChild(imgElement);
    });

    expect(fetch).toHaveBeenCalledWith('/user/images');
    expect(images.length).toBe(0);
    expect(userImagesDiv.children.length).toBe(0); // No images should be added
  });

  test('should fetch and display images from other users', async () => {
    // Mock the response for other users' images
    fetchMock.mockResponseOnce(JSON.stringify([
      { file_path: 'other_user_image1.jpg' },
      { file_path: 'other_user_image2.jpg' }
    ]));

    const response = await fetch('/other-users/images');
    const images = await response.json();

    const otherUsersImagesDiv = document.getElementById('other-users-images');
    images.forEach(image => {
      const imgElement = document.createElement('img');
      imgElement.src = `/storage/${image.file_path}`;
      otherUsersImagesDiv.appendChild(imgElement);
    });

    expect(fetch).toHaveBeenCalledWith('/other-users/images');
    expect(images.length).toBe(2);
    expect(otherUsersImagesDiv.children.length).toBe(2);
  });

  test('should handle fetch error gracefully for other users\' images', async () => {
    // Simulate a fetch error
    fetchMock.mockRejectOnce(new Error('Failed to fetch'));

    try {
      await fetch('/other-users/images');
    } catch (error) {
      // Ensure that the error is caught
      expect(error.message).toBe('Failed to fetch');
    }

    // Ensure that no images are added to the DOM
    const otherUsersImagesDiv = document.getElementById('other-users-images');
    expect(otherUsersImagesDiv.children.length).toBe(0);
  });

  test('should fetch and display latest images', async () => {
    // Mock the response for latest images
    fetchMock.mockResponseOnce(JSON.stringify([
      { file_path: 'latest_image1.jpg' },
      { file_path: 'latest_image2.jpg' }
    ]));

    const response = await fetch('/latest/images');
    const images = await response.json();

    const latestImagesDiv = document.getElementById('latest-images');
    images.forEach(image => {
      const imgElement = document.createElement('img');
      imgElement.src = `/storage/${image.file_path}`;
      latestImagesDiv.appendChild(imgElement);
    });

    expect(fetch).toHaveBeenCalledWith('/latest/images');
    expect(images.length).toBe(2);
    expect(latestImagesDiv.children.length).toBe(2);
  });

  test('should not display images when API returns empty array for latest images', async () => {
    // Mock empty response
    fetchMock.mockResponseOnce(JSON.stringify([]));

    const response = await fetch('/latest/images');
    const images = await response.json();

    const latestImagesDiv = document.getElementById('latest-images');
    images.forEach(image => {
      const imgElement = document.createElement('img');
      imgElement.src = `/storage/${image.file_path}`;
      latestImagesDiv.appendChild(imgElement);
    });

    expect(fetch).toHaveBeenCalledWith('/latest/images');
    expect(images.length).toBe(0);
    expect(latestImagesDiv.children.length).toBe(0); // No images should be added
  });
});
