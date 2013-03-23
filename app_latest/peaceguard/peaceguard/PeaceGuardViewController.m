//
//  PeaceGuardViewController.m
//
//  Contributor(s): Ashley Lesperance
//
//  Copyright (c) 2013 Number 123 Developer's Group
//


#import "PeaceGuardViewController.h"
#import "User.h"
#import "UserDataController.h"

#import "MainViewController.h"

@interface PeaceGuardViewController (){
    CLGeocoder *geocoder;
    CLPlacemark *placemark;
}

@end

@implementation PeaceGuardViewController


- (void)touchesBegan:(NSSet *)touches withEvent:(UIEvent *)event
{
    [self.view endEditing:YES];
    [UIView beginAnimations:nil context:NULL];
    [UIView setAnimationDuration:0.25];
    self.view.center = CGPointMake(self.originalCenter.x, self.originalCenter.y-44);
    [UIView commitAnimations];
}

- (BOOL)textFieldShouldReturn:(UITextField *)textField {
    [textField resignFirstResponder];
    [UIView beginAnimations:nil context:NULL];
    [UIView setAnimationDuration:0.25];
    //self.view.frame = CGRectMake(0,-10,320,400);
    self.view.center = CGPointMake(self.originalCenter.x, self.originalCenter.y-44);
    [UIView commitAnimations];
    return YES;
}


- (void)keyboardDidShow:(NSNotification *)note
{
    [UIView beginAnimations:nil context:NULL];
    [UIView setAnimationDuration:0.25];
    //self.view.frame = CGRectMake(0,-10,320,400);
    self.view.center = CGPointMake(self.originalCenter.x, 10);
    [UIView commitAnimations];
}

- (void)keyboardDidHide:(NSNotification *)note
{
    [UIView beginAnimations:nil context:NULL];
    [UIView setAnimationDuration:0.25];
    //self.view.frame = CGRectMake(0,-10,320,400);
    self.view.center = self.originalCenter;
    [UIView commitAnimations];
}

- (IBAction)Login:(id)sender {
    //BOOL authentication = [self logUsername:self.username.text password:self.password.text];
    //self.usernameData = self.username.text;
    self.user = [[User alloc] initWithUsername:self.username.text password:self.password.text];
    self.connectionManager = [[ConnectionDataController alloc] init];
    BOOL authentication = [self.connectionManager serverLoginWithEmail:self.username.text andPassword:self.password.text];
    //self.username.text = @"";
    self.password.text = @"";
    
    if( authentication == YES) {
        //the login is correct
        NSUserDefaults *defaults = [NSUserDefaults standardUserDefaults];
        [defaults setObject:self.username forKey:@"username"];
        [defaults synchronize];
        [self performSegueWithIdentifier:@"ToMainMenu" sender:self];
    }
}



- (void)viewDidLoad
{
    [super viewDidLoad];
    [[NSNotificationCenter defaultCenter] addObserver:self selector:@selector(keyboardDidShow:) name:UIKeyboardDidShowNotification object:nil]; 
    self.originalCenter = self.view.center;
    NSURL*url=[NSURL URLWithString:@"https://vancouver.ca/police/"];
    NSURLRequest*request=[NSURLRequest requestWithURL:url];
    [_help loadRequest:request];
    _locationManager = [[CLLocationManager alloc] init];
    [_locationManager startUpdatingLocation];
    geocoder = [[CLGeocoder alloc] init];
    [self deviceLocation];
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

//Get the current location and set it as a global location, so user won't lost the location
//without the patrolling
- (void)deviceLocation {
    [geocoder reverseGeocodeLocation:_locationManager.location completionHandler:^(NSArray *placemarks, NSError *error) {
        if (error == nil && [placemarks count] > 0){
            placemark = [placemarks lastObject];
            NSUserDefaults *defaults = [NSUserDefaults standardUserDefaults];
            NSString *current_location = [NSString stringWithFormat:@"%@ %@\n%@ %@\n%@\n%@",
                                          placemark.subThoroughfare, placemark.thoroughfare,
                                          placemark.postalCode, placemark.locality,
                                          placemark.administrativeArea,
                                          placemark.country];
            [defaults setObject:current_location forKey:@"currentLocation"];
            [defaults synchronize];
        } else{
            NSLog(@"%@", error.debugDescription);
        }
    }
    ];
}

- (void)prepareForSegue:(UIStoryboardSegue *)segue sender:(id)sender{
        MainViewController *mainContoller = (MainViewController *)segue.destinationViewController;
        mainContoller.usernameData = self.username.text;

}


@end
