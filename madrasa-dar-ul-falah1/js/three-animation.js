// three-animation.js — 3D Lantern + Particle Hero Animation

(function() {
  const canvas = document.getElementById('lantern-canvas');
  if (!canvas) return;

  const scene = new THREE.Scene();
  const camera = new THREE.PerspectiveCamera(45, canvas.clientWidth / canvas.clientHeight, 0.1, 100);
  camera.position.set(0, 0, 5);

  const renderer = new THREE.WebGLRenderer({ canvas, alpha: true, antialias: true });
  renderer.setSize(canvas.clientWidth, canvas.clientHeight);
  renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
  renderer.setClearColor(0x000000, 0);

  // Lighting
  const ambient = new THREE.AmbientLight(0xffffff, 0.4);
  scene.add(ambient);
  const goldLight = new THREE.PointLight(0xc9a84c, 3, 10);
  goldLight.position.set(0, 2, 2);
  scene.add(goldLight);
  const greenLight = new THREE.PointLight(0x1a6b3c, 2, 8);
  greenLight.position.set(-2, -1, 1);
  scene.add(greenLight);
  const whiteLight = new THREE.DirectionalLight(0xffffff, 0.6);
  whiteLight.position.set(3, 3, 3);
  scene.add(whiteLight);

  // === LANTERN GROUP ===
  const lanternGroup = new THREE.Group();
  scene.add(lanternGroup);

  // Materials
  const goldMat = new THREE.MeshStandardMaterial({ color: 0xc9a84c, metalness: 0.8, roughness: 0.2 });
  const glassMat = new THREE.MeshStandardMaterial({ color: 0xffeeaa, transparent: true, opacity: 0.4, metalness: 0.1, roughness: 0.1 });
  const darkMat = new THREE.MeshStandardMaterial({ color: 0x0f4a28, metalness: 0.6, roughness: 0.3 });

  // Top dome
  const dome = new THREE.Mesh(new THREE.SphereGeometry(0.35, 16, 8, 0, Math.PI*2, 0, Math.PI/2), goldMat);
  dome.position.y = 1.2;
  lanternGroup.add(dome);

  // Top finial
  const finial = new THREE.Mesh(new THREE.ConeGeometry(0.08, 0.4, 8), goldMat);
  finial.position.y = 1.7;
  lanternGroup.add(finial);

  // Top ring
  const topRing = new THREE.Mesh(new THREE.TorusGeometry(0.36, 0.04, 8, 24), goldMat);
  topRing.position.y = 1.2;
  topRing.rotation.x = Math.PI/2;
  lanternGroup.add(topRing);

  // Body (main lantern cage - hexagonal)
  const bodyHeight = 1.6;
  for (let i = 0; i < 6; i++) {
    const angle = (i / 6) * Math.PI * 2;
    const x = Math.cos(angle) * 0.38;
    const z = Math.sin(angle) * 0.38;
    const bar = new THREE.Mesh(new THREE.CylinderGeometry(0.025, 0.025, bodyHeight, 6), goldMat);
    bar.position.set(x, 0, z);
    lanternGroup.add(bar);
  }

  // Glass panels (6 sides)
  for (let i = 0; i < 6; i++) {
    const angle = (i / 6) * Math.PI * 2 + Math.PI/6;
    const panelGeo = new THREE.PlaneGeometry(0.38, bodyHeight - 0.1);
    const panel = new THREE.Mesh(panelGeo, glassMat);
    panel.position.set(Math.cos(angle)*0.37, 0, Math.sin(angle)*0.37);
    panel.rotation.y = -angle;
    lanternGroup.add(panel);
  }

  // Top & bottom rings for body
  [-bodyHeight/2, bodyHeight/2].forEach(y => {
    const ring = new THREE.Mesh(new THREE.TorusGeometry(0.4, 0.04, 8, 24), goldMat);
    ring.position.y = y;
    ring.rotation.x = Math.PI/2;
    lanternGroup.add(ring);
    // Decorative star cuts
    for (let i = 0; i < 6; i++) {
      const a = (i/6)*Math.PI*2;
      const pt = new THREE.Mesh(new THREE.SphereGeometry(0.05, 6, 6), goldMat);
      pt.position.set(Math.cos(a)*0.4, y, Math.sin(a)*0.4);
      lanternGroup.add(pt);
    }
  });

  // Bottom
  const bottom = new THREE.Mesh(new THREE.CylinderGeometry(0.25, 0.05, 0.15, 8), goldMat);
  bottom.position.y = -bodyHeight/2 - 0.08;
  lanternGroup.add(bottom);
  const bottomChain = new THREE.Mesh(new THREE.CylinderGeometry(0.02, 0.02, 0.4, 6), darkMat);
  bottomChain.position.y = -bodyHeight/2 - 0.4;
  lanternGroup.add(bottomChain);
  const bottomBall = new THREE.Mesh(new THREE.SphereGeometry(0.08, 8, 8), goldMat);
  bottomBall.position.y = -bodyHeight/2 - 0.65;
  lanternGroup.add(bottomBall);

  // Inner light glow
  const glowLight = new THREE.PointLight(0xffaa00, 2, 2);
  glowLight.position.set(0, 0, 0);
  lanternGroup.add(glowLight);
  const glowSphere = new THREE.Mesh(new THREE.SphereGeometry(0.15, 8, 8), new THREE.MeshBasicMaterial({ color: 0xffdd88, transparent: true, opacity: 0.6 }));
  lanternGroup.add(glowSphere);

  lanternGroup.position.y = -0.2;

  // === HANGING CHAIN ===
  for (let i = 0; i < 6; i++) {
    const a = (i/6)*Math.PI*2;
    const chain = new THREE.Mesh(new THREE.CylinderGeometry(0.015, 0.015, 0.5, 4), darkMat);
    chain.position.set(Math.cos(a)*0.3, bodyHeight/2 + 0.5, Math.sin(a)*0.3);
    chain.rotation.z = Math.atan2(Math.cos(a)*0.3, 0.5);
    lanternGroup.add(chain);
  }

  // === PARTICLES ===
  const particleCount = 180;
  const positions = new Float32Array(particleCount * 3);
  const sizes = new Float32Array(particleCount);
  const particleSpeeds = new Float32Array(particleCount);

  for (let i = 0; i < particleCount; i++) {
    positions[i*3]   = (Math.random() - 0.5) * 10;
    positions[i*3+1] = (Math.random() - 0.5) * 10;
    positions[i*3+2] = (Math.random() - 0.5) * 8;
    sizes[i] = Math.random() * 0.05 + 0.01;
    particleSpeeds[i] = Math.random() * 0.005 + 0.002;
  }

  const particleGeo = new THREE.BufferGeometry();
  particleGeo.setAttribute('position', new THREE.BufferAttribute(positions, 3));
  particleGeo.setAttribute('size', new THREE.BufferAttribute(sizes, 1));

  const particleMat = new THREE.PointsMaterial({
    color: 0xc9a84c, transparent: true, opacity: 0.6,
    size: 0.04, sizeAttenuation: true
  });
  const particles = new THREE.Points(particleGeo, particleMat);
  scene.add(particles);

  // === FLOATING GEOMETRIC SHAPES ===
  const starGeometry = new THREE.OctahedronGeometry(0.15, 0);
  const starMat = new THREE.MeshStandardMaterial({ color: 0xc9a84c, wireframe: true, transparent: true, opacity: 0.4 });
  const floatingStars = [];
  for (let i = 0; i < 5; i++) {
    const star = new THREE.Mesh(starGeometry, starMat);
    star.position.set((Math.random()-0.5)*4, (Math.random()-0.5)*3, (Math.random()-0.5)*2 - 1);
    star.userData = { speed: Math.random()*0.02+0.005, offset: Math.random()*Math.PI*2 };
    scene.add(star);
    floatingStars.push(star);
  }

  // Mouse interaction
  let mouseX = 0, mouseY = 0;
  const onMouseMove = (e) => {
    const rect = canvas.getBoundingClientRect();
    mouseX = ((e.clientX - rect.left) / rect.width - 0.5) * 2;
    mouseY = -((e.clientY - rect.top) / rect.height - 0.5) * 2;
  };
  window.addEventListener('mousemove', onMouseMove);

  // Resize
  const onResize = () => {
    const w = canvas.clientWidth, h = canvas.clientHeight;
    camera.aspect = w / h;
    camera.updateProjectionMatrix();
    renderer.setSize(w, h);
  };
  window.addEventListener('resize', onResize);

  let time = 0;
  const animate = () => {
    requestAnimationFrame(animate);
    time += 0.016;

    // Lantern float + slight mouse follow
    lanternGroup.rotation.y += 0.008;
    lanternGroup.position.y = -0.2 + Math.sin(time * 0.7) * 0.12;
    lanternGroup.rotation.x += (mouseY * 0.15 - lanternGroup.rotation.x) * 0.04;

    // Glow pulse
    glowLight.intensity = 2 + Math.sin(time * 2) * 0.8;
    glowSphere.material.opacity = 0.4 + Math.sin(time * 2) * 0.2;
    goldLight.intensity = 3 + Math.sin(time * 1.3) * 0.5;

    // Particles drift upward
    const pos = particleGeo.attributes.position.array;
    for (let i = 0; i < particleCount; i++) {
      pos[i*3+1] += particleSpeeds[i];
      if (pos[i*3+1] > 5) {
        pos[i*3+1] = -5;
        pos[i*3]   = (Math.random()-0.5)*10;
        pos[i*3+2] = (Math.random()-0.5)*8;
      }
    }
    particleGeo.attributes.position.needsUpdate = true;
    particles.rotation.y += 0.001;

    // Floating stars
    floatingStars.forEach(s => {
      s.rotation.x += s.userData.speed;
      s.rotation.y += s.userData.speed * 0.7;
      s.position.y += Math.sin(time + s.userData.offset) * 0.003;
    });

    renderer.render(scene, camera);
  };
  animate();
})();
